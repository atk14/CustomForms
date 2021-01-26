<?php
class CustomFormFieldChoicesForm extends AdminForm {
	
	function set_up(){
		$this->add_translatable_field("title", new CharField([
			"label" => _("Titulek"),
			"required" => false,
			"hints" => [
				"modrá",
				"zelená",
				"žlutá",
			],
		]));

		$this->add_field("name", new CharField([
			"label" => _("Název volby (počítačový)"),
			"hints" => [
				"green",
				"blue",
				"yellow",
			],
		]));
	}
}
