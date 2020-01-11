<?php
class DetailForm extends ApplicationForm {

	function set_up(){
	}

	function prepare_for_custom_form($custom_form){
		global $HTTP_REQUEST;

		$this->set_method("post");
		$this->set_attr("id","custom_form");
		$this->set_action($HTTP_REQUEST->getRequestUri()."#custom_form");
		$this->set_button_text($custom_form->getButtonText());

		foreach($custom_form->getFields() as $field){
			$class_name = $field->getClassName();
			$options = [
				"label" => $field->getLabel(),
				"required" => $field->isRequired(),
			];
			if($field->getHelpText()){
				// the default help_text should be used if there is no specific
				$options["help_text"] = $field->getHelpText();
			}
			if($field->choicesRequired()){
				$choices = [];
				foreach($field->getChoices() as $choice){
					$choices[$choice->getName()] = $choice->getTitle();
				}
				$options["choices"] = $choices;
			}
			$this->add_field($field->getName(),new $class_name($options));
		}
	}
}
