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

	function _before_filter(){
		if(in_array($this->action,["index","create_new"])){
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
