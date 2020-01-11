<?php
namespace CustomFormFields;

/**
 * Výběr hodnoty (radio buttons)
 */
class RadioChoiceField extends \ChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new \RadioSelect(),
		];

		parent::__construct($options);
	}
}
