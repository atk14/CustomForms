<?php
class CustomFormFieldsetField extends ChoiceField {

	function __construct($custom_form,$options = []){

		if($custom_form){
			$choices = [];
			foreach($custom_form->getFieldsets() as $fieldset){
				$choices[$fieldset->getId()] = strlen($fieldset->getTitle()) ? $fieldset->getTitle() : _("bez názvu");
			}
		}else{
			$choices = ["" => ""];
		}

		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
