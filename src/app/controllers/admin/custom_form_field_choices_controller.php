<?php
require_once(__DIR__ . "/trait_custom_forms_utils.php");

class CustomFormFieldChoicesController extends AdminController {

	use TraitCustomFormsUtils;

	function index(){
		$this->page_title = _("Seznam voleb");

		$this->tpl_data["choices"] = $this->custom_form_field->getChoices();
	}
	
	function create_new(){
		$custom_form_field = $this->custom_form_field;
		$this->_add_custom_form_field_to_breadcrumbs($custom_form_field);

		$this->_create_new([
			"page_title" => _("Přidat novou volbu"),
			"create_closure" => function($d) use($custom_form_field){
				$d["custom_form_field_id"] = $custom_form_field;
				return CustomFormFieldChoice::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_add_custom_form_field_to_breadcrumbs($this->custom_form_field_choice->getCustomFormField());
		$this->_edit([
			"page_title" => _("Editace volby")
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function export_choices(){
		global $ATK14_GLOBAL;

		$langs = $ATK14_GLOBAL->getSupportedLangs();

		$csv = new CsvWriter();

		$choices = CustomFormFieldChoice::FindAll("custom_form_field_id",$this->custom_form_field);
		foreach($choices as $choice){
			$row = [
				"name" => $choice->getName(),
			];
			foreach($langs as $l){
				$row["title_$l"] = $choice->g("title_$l");
			}
			$csv[] = $row;
		}

		$export_options = ["with_header" => true];
		if(!$choices){
			$row = ["name"];
			foreach($langs as $l){
				$row[] = "title_$l";
			}
			$csv[] = $row;
			$export_options["with_header"] = false;
		}

		$this->render_template = false;

		$this->response->setContentType("text/csv");
		$this->response->setHeader(sprintf('Content-Disposition: inline; filename="%s"',
			String4::ToObject($this->custom_form_field->getName())->append("_")->append(_("choices"))->toAscii()->underscore()->append(".csv")->toString()
		));
		$this->response->write($csv->writeToString($export_options));
	}

	function import_choices(){
		$this->page_title = sprintf(_("Import voleb pro políčko '%s'"),h($this->custom_form_field->getName()));
		$this->_add_custom_form_field_to_breadcrumbs($this->custom_form_field);

		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			if($d["delete_current_choices"]){
				foreach(CustomFormFieldChoice::FindAll("custom_form_field_id",$this->custom_form_field) as $choice){
					$choice->destroy();
				}
			}
			foreach($d["csv"] as $values){
				$values["custom_form_field_id"] = $this->custom_form_field;
				CustomFormFieldChoice::CreateNewRecord($values);
			}

			$this->flash->success(_("Import byl úspěšně proveden"));
			$this->_redirect_back();
		}
	}

	function _before_filter(){
		if(in_array($this->action,["index","create_new","export_choices","import_choices"])){
			$this->_find("custom_form_field","custom_form_field_id");
		}
		if(in_array($this->action,["edit"])){
			$_choice = $this->_find("custom_form_field_choice");
			if($_choice){
				$this->custom_form_field = $_choice->getCustomFormField();
			}
		}
	}
}
