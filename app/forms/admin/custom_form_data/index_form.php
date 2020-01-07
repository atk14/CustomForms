<?php
class IndexForm extends AdminForm {

	function set_up(){
		$this->add_field("page_title", new ChoiceField([
			"label" => _("Formulář ke stránce"),
			"required" => false
		]));
	}
}
