<?php
trait TraitCustomFormsUtils {

	function _add_custom_form_to_breadcrumbs($custom_form){
		if(!$custom_form){ return; }
		$this->breadcrumbs[] = [sprintf(_("Editace formuláře %s"),$custom_form->getTitle()),$this->_link_to(["action" => "custom_forms/edit", "id" => $custom_form])];
	}

	function _add_custom_form_field_to_breadcrumbs($custom_form_field){
		if(!$custom_form_field){ return; }
		$this->_add_custom_form_to_breadcrumbs($custom_form_field->getCustomForm());
		$this->breadcrumbs[] = [sprintf(_("Editace políčka %s"),h($custom_form_field->getLabel())),$this->_link_to(["action" => "custom_form_fields/edit", "id" => $custom_form_field])];
	}

}
