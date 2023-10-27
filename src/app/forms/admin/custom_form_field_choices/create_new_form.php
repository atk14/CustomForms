<?php
class CreateNewForm extends CustomFormFieldChoicesForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(is_array($d) && isset($d["name"])){
			if(CustomFormFieldChoice::FindFirst("custom_form_field_id",$this->controller->custom_form_field,"name",$d["name"])){
				$this->set_error("name",sprintf(_("Volba <em>%s</em> již u tohoto políčka existuje"),h($d["name"])));
			}
		}
	
		return [$err,$d];
	}
}
