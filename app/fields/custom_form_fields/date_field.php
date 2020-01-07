<?php
namespace CustomFormFields;

/**
 * Datum
 */
class DateField extends \DateField {

	function __construct($options = []){
		$options += [
			"hint" => \Atk14Locale::FormatDate("2000-12-31"),
		];
		parent::__construct($options);
	}
}
