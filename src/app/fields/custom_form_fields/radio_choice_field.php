<?php
namespace CustomFormFields;

/**
 * Value selection (radio buttons)
 *
 * cs: Výběr hodnoty (radio buttons)
 */
class RadioChoiceField extends \ChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new \RadioSelect(),
		];

		parent::__construct($options);
	}
}
