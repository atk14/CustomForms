<?php
namespace CustomFormFields;

/**
 * Textové políčko (dlouhý text)
 */
class TextField extends \TextField {

	function __construct($options = []){
		$options += [
			"max_length" => 1000,
		];

		parent::__construct($options);
	}
}
