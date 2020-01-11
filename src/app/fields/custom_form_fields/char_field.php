<?php
namespace CustomFormFields;

/**
 * Textové políčko (krátký text)
 */
class CharField extends \CharField {
	
	function __construct($options = []){
		$options += [
			"max_length" => 200,
		];

		parent::__construct($options);
	}
}

