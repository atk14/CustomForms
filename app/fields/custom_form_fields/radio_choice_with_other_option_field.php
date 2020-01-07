<?php
namespace CustomFormFields;

/**
 * Výběr hodnoty s jinou možností (radio buttons + textarea)
 */
class RadioChoiceWithOtherOptionField extends RadioChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new \CustomFormWidgets\RadioSelectWithTextArea(),
			"choices" => [],
			"text_max_length" => 500,
		];

		$options["choices"] += [
			"other" => _("Jiná možnost (uveďte)")
		];

		$this->text_max_length = $options["text_max_length"];

		parent::__construct($options);
	}

	function clean($value){
		list($err,$value) = parent::clean($value);
		if(!is_null($err)){
			return [$err,null];
		}

		$text = new \String4($this->widget->text);
		$text = $text->trim();

		if($value=="other" && !$text->length()){
			return [_("Uveďte jinou možnost"),null];
		}

		if($text->length()>$this->text_max_length){
			return [strtr(_("Text je příliš dlouhý, zkraťte jej na max. %max_length% znaků"),["%max_length%" => $this->text_max_length]),null];
		}

		if(strlen($text)){
			$value .= " \"$text\"";
		}

		return [$err,$value];
	}
}
