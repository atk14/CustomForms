<?php
class IndexForm extends AdminForm {

	function set_up(){
		$f = $this->add_field("q", new SearchField([
			"label" => _("Hledat"),
			"required" => false,
			"max_length" => 200,
		]));
		$f->widget->attrs["placeholder"] = _("Hledat");

		$this->add_field("page_title", new ChoiceField([
			"label" => _("Formulář ke stránce"),
			"required" => false
		]));
	}
}
