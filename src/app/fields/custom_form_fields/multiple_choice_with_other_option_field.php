<?php
namespace CustomFormFields;

/**
 * Selecting multiple values with a different option (checkboxes + textarea)
 *
 * cs: Výběr více hodnot s jinou možností (checkboxes + textarea)
 */
class MultipleChoiceWithOtherOptionField extends MultipleChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new \CustomFormWidgets\CheckboxSelectMultipleWithTextArea(),
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

		if(in_array("other",$value) && !$text->length()){
			return [_("Uveďte jinou možnost"),null];
		}

		if($text->length()>$this->text_max_length){
			return [strtr(_("Text je příliš dlouhý, zkraťte jej na max. %max_length% znaků"),["%max_length%" => $this->text_max_length]),null];
		}

		if(strlen($text)){
			$value[] = "\"$text\"";
		}

		return [$err,$value];
	}
}
