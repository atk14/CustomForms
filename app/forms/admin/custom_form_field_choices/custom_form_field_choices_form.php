<?php
class CustomFormFieldChoicesForm extends AdminForm {
	
	function set_up(){
		$this->add_field("name", new CharField([
			"label" => _("Název volby"),
			"hints" => [
				"green",
				"blue",
				"yellow",
			],
		]));

		$this->add_translatable_field("title", new CharField([
			"label" => _("Zobrazovaný titulek"),
			"required" => false,
			"hints" => [
				"modrá",
				"zelená",
				"žlutá",
			],
		]));
	}
}
