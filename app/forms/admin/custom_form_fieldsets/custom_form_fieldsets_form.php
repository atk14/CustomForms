<?php
class CustomFormFieldsetsForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("title", new CharField([
			"label" => _("Název"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_translatable_field("description", new WysiwygField([
			"label" => _("Popis"),
			"required" => false,
		]));
	}
}
