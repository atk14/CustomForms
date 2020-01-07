<?php
require_once(__DIR__ . "/trait_custom_forms_utils.php");

class CustomFormFieldsController extends AdminController {

	use TraitCustomFormsUtils;

	function create_new(){
		$custom_form_fieldset = $this->custom_form_fieldset;
		$custom_form = $custom_form_fieldset->getCustomForm();

		$this->_add_custom_form_to_breadcrumbs($custom_form);

		$this->_create_new([
			"page_title" => sprintf(_("Přidání políčka do formuláře %s"),h($this->custom_form->getTitle())),
			"create_closure" => function($d) use($custom_form_fieldset){
				$d["custom_form_fieldset_id"] = $custom_form_fieldset;
				$d["custom_form_id"] = $custom_form_fieldset->getCustomFormId();
				return CustomFormField::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_add_custom_form_to_breadcrumbs($this->custom_form);

		$this->_edit([
			"page_title" => sprintf(_("Editace políčka ve formuláři %s"),h($this->custom_form->getTitle())),
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		$cf_fieldset = null;
		if(in_array($this->action,["create_new"])){
			$cf_fieldset = $this->_find("custom_form_fieldset","custom_form_fieldset_id");
		}
		if(in_array($this->action,["edit"])){
			$cf_field = $this->_find("custom_form_field");
			if($cf_field){ $cf_fieldset = $cf_field->getCustomFormFieldset(); }
		}
		
		if($cf_fieldset){ $this->custom_form = $this->tpl_data["custom_form"] = $cf_fieldset->getCustomForm(); }
	}
}
