<?php
require_once(__DIR__ . "/trait_custom_forms_utils.php");

class CustomFormDataController extends AdminController {

	use TraitCustomFormsUtils;

	function _conditions() {
		$conditions = ['custom_form_id = :id' ];
		$bind_ar = [':id' => $this->custom_form ];
		$choices = $this->dbmole->selectIntoArray("SELECT page_title FROM custom_form_data WHERE custom_form_id = :id",$bind_ar);
		$choices = ['' => _('-- '._('filtrovat data podle stránky').' --')] + array_combine($choices, $choices);
		$this->form->fields['page_title']->set_choices($choices);
		$this->form->set_hidden_field('custom_form_id', $this->custom_form);
		if($this->filter_params = $d = $this->form->validate($this->params)) {
			if($d['page_title']) {
				$conditions[] = 'page_title = :page_title';
				$bind_ar[':page_title'] = $d['page_title'];
			}
		} else {
			$this->filter_params = [];
		}
		return [$conditions, $bind_ar];
	}

	function _get_writer(){
		list($headers, $rows) = CustomFormData::DataExport($this->finder,[ 'replace_newline' => true ]);

		$writer = new CsvWriter([
			"delimiter" => ";",
			"quote" => '"',
			"escape_char" => "\\",
		]);
		$writer->addRow($headers);
		$writer->addRows($rows);

		return $writer;
	}

	function _csv() {
		$writer = $this->_get_writer();

		$this->render_template = false;
		$this->response->setContentType("text/csv; charset=UTF-8");
		$date = date("Y-m-d_H:i:s");
		$this->response->setHeader("Content-disposition", "attachment; filename=\"{$this->custom_form->getTitle()}-$date.csv\"");
		$this->render_template = false;
		$this->response->write($writer->writeToString());
	}

	function _xls() {
		$writer = $this->_get_writer();

		$this->render_template = false;
		$this->response->setContentType("application/vnd.ms-excel");
		$date = date("Y-m-d_H:i:s");
		$this->response->setHeader("Content-disposition", "attachment; filename=\"{$this->custom_form->getTitle()}-$date.xlsx\"");
		$this->response->write($writer->writeToString(["format" => "xlsx", "sheet_name" => $this->custom_form->getTitle()]));
	}

	function index(){
		$custom_form = $this->custom_form;
		$this->page_title = sprintf(_("Data formuláře %s"),$custom_form->getTitle());

		$this->sorting->add("created_at",["reverse" => true]);
		$this->sorting->add("page_title","UPPER(page_title), page_title, created_at DESC","UPPER(page_title) DESC, page_title DESC, created_at DESC");
		$this->sorting->add("id");

		list($conditions, $bind_ar) = $this->_conditions();

		$format = $this->params->g("format");
		$params = [
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
		];

		if(!$format) {
			$params["offset"] = $this->params->getInt("offset");
		} else {
			$params["limit"] = null;
		}

		$this->tpl_data["finder"] = $this->finder = CustomFormData::Finder($params);
		if($format) {
			if($this->finder->getRecords()) {
				switch($format) {
					case 'csv': $this->_csv(); break;
					default:    $this->_xls();
				}
			} else {
				$this->flash->warning(_("Nenalezena žádná data"));
			}
		}
	}

	function detail(){
		$custom_form = $this->custom_form_data->getCustomForm();
		$this->page_title = sprintf(_("Data z formuláře %s"),$custom_form->getTitle());

		$this->tpl_data["data"] = $this->custom_form_data->getDataAsArray();
	}

	function destroy(){
		$this->_destroy($this->custom_form_data); // Bez doslovneho predani objektu se smazani nepodari (error404). Velice zajimave!
	}

	function bulk_destroy(){
		$this->page_title = _("Hromadné smazání dat");

		$this->_save_return_uri();

		if($this->request->post() && $this->form->validate($this->params)){
			$this->dbmole->doQuery("DELETE FROM custom_form_data WHERE custom_form_id=:custom_form_id",[":custom_form_id" => $this->custom_form]);

			$this->flash->notice(sprintf(_("Záznamy (%s) byly úspěšně smazány"),$this->dbmole->getAffectedRows()));
			$this->_redirect_back();
		}
	}

	function _before_filter(){
		$cf = $cfd = null;
		if(in_array($this->action,["index","bulk_destroy"])){
			$cf = $this->_find("custom_form","custom_form_id");
		}
		if(in_array($this->action,["detail","destroy"])){
			$cfd = $this->_find("custom_form_data");
		}
		
		if($cfd){
			$cf = $cfd->getCustomForm();
		}

		if($cf){
			$this->_add_custom_form_to_breadcrumbs($cf);
			$this->breadcrumbs[] = ["Data",$this->_link_to(["action" => "custom_form_data/index", "custom_form_id" => $cf])];
		}
	}
}
