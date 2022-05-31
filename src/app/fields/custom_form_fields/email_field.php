<?php
namespace CustomFormFields;

/**
 * E-mail
 *
 * cs: E-mail
 */
class EmailField extends \EmailField {

	function __construct($options = []){
		$options += [
			"initial" => "@"
		];
		parent::__construct($options);
	}
}
