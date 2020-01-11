<?php
class CustomFormChoiceField extends ChoiceField {
	
	function __construct($options = []){

		$choices = ["" => ""];
		foreach(CustomForm::FindAll([]) as $form){
			$choices[$form->getId()] = $form->getTitle();
		}
		$options["choices"] = $choices;
		
		parent::__construct($options);
	}
}
