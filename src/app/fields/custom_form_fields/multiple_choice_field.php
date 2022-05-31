<?php
namespace CustomFormFields;

/**
 * Select multiple values (checkboxes)
 *
 * cs: Výběr více hodnot (checkboxes)
 */
class MultipleChoiceField extends \MultipleChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new \CheckboxSelectMultiple()
		];

		parent::__construct($options);
	}
}
