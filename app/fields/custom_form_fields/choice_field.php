<?php
namespace CustomFormFields;

/**
 * Výběr hodnoty (select box)
 */
class ChoiceField extends \ChoiceField {

	function __construct($options = []){
		$options += [
			"choices" => []
		];

		if(!isset($options["choices"][""])){
			$choices = ["" => "-- "._("vyberte")." --"];
			foreach($options["choices"] as $k => $v){
				$choices[$k] = $v;
			}
			$options["choices"] = $choices;
		}

		parent::__construct($options);
	}
}
