<?php
require_once(__DIR__ . "/trait_custom_forms_utils.php");

class CustomFormFieldsetsController extends AdminController {

	use TraitCustomFormsUtils;

	function index(){
		$this->page_title = _("Fieldsety formuláře");

		$this->tpl_data["custom_form_fieldsets"] = $this->custom_form->getCustomFormFieldsets();
	}

	function create_new(){
		$custom_form = $this->custom_form;

		$this->_create_new([
			"create_closure" => function($d) use($custom_form){
				$d["custom_form_id"] = $custom_form;
				return CustomFormFieldset::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace fieldsetu"),
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function _before_filter(){
		$custom_form = null;

		if(in_array($this->action,["index","create_new"])){
			$custom_form = $this->_find("custom_form","custom_form_id");
		}
		if(in_array($this->action,["edit"])){
			$cff = $this->_find("custom_form_fieldset");
			if($cff){ $custom_form = $this->custom_form = $cff->getCustomForm(); }
		}

		$this->_add_custom_form_to_breadcrumbs($custom_form);
	}
}
