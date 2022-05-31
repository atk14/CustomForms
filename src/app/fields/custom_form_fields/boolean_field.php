<?php
namespace CustomFormFields;

/**
 * Checkbox
 *
 * cs: Checkbox
 */
class BooleanField extends \BooleanField {

	function __construct($options = []){
		$options["required"] = false; // it makes no sence to set required on a BooleanField since it's widget is Checkbox
		parent::__construct($options);
	}
}
