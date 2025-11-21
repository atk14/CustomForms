<?php
class CustomFormsController extends AdminController {

	function index(){
		$this->page_title = _("Formuláře");

		$conditions = $bind_ar = array();

		$this->sorting->add("created_at",["revrese" => true]);
		$this->sorting->add("id");
		$this->sorting->add("title","UPPER(COALESCE((SELECT body FROM translations WHERE record_id=custom_forms.id AND table_name='custom_forms' AND key='title' AND lang=:lang),''))");
		$_last_submitted_at = "(SELECT COALESCE(MAX(created_at),'2000-01-01') FROM custom_form_data WHERE custom_form_id=custom_forms.id)";
		$this->sorting->add("last_submitted_at","$_last_submitted_at DESC","$_last_submitted_at ASC");

		$bind_ar[":lang"] = $this->lang;

		$this->tpl_data["finder"] = CustomForm::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
			"offset" => $this->params->getInt(ATK14_PAGINATOR_OFFSET_PARAM_NAME)
		]);
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("Vytvoření formuláře"),
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => sprintf(_("Editace formuláře %s"),h($this->custom_form->getTitle())),
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("custom_form");
		}
	}
}
