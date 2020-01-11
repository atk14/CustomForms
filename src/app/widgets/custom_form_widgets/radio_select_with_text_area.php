<?php
namespace CustomFormWidgets;

class RadioSelectWithTextArea extends \RadioSelect {

	var $text; // Zde bude nastaven text, ktery byde zadan do textarey

	function render($name, $value, $options = []){
		global $HTTP_REQUEST;

		$textarea_name = "{$name}_text";
		$textarea_attrs = [
			"name" => $textarea_name,
			"class" => "form-control",
		];
		$text = (string)$HTTP_REQUEST->getPostVar($textarea_name);

		$out = parent::render($name, $value, $options);
		$out .= '<textarea'.flatatt($textarea_attrs).'>'.h($text).'</textarea>';

		$out = '<div class="form-control-wrap">'.$out.'</div>';

		return $out;
	}

	function value_from_datadict($data,$name){
		global $HTTP_REQUEST;
		$out = parent::value_from_datadict($data,$name);

		$textarea_name = "{$name}_text";
		$text = (string)$HTTP_REQUEST->getVar($textarea_name,"PG");
		$this->text = $text;

		return $out;
	}
}
