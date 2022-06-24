<?php
class CustomFormFieldsForm extends AdminForm {

	function set_up(){
		$this->add_field("custom_form_fieldset_id", new CustomFormFieldsetField($this->controller->custom_form,[
			"label" => _("Fieldset"),
		]));

		$choices = [];
		foreach(CustomFormField::GetSupportedFields() as $item){
			$choices[$item["class_name"]] = $item["name"];
		}
		$this->add_field("class_name", new ChoiceField([
			"label" => _("Typ políčka"),
			"choices" => $choices,
		]));

		$this->add_translatable_field("label", new CharField([
			"label" => _("Titulek"),
			"max_length" => 255,
			"hints" => [
				"Jméno",
				"Rok narození"
			],
		]));

		$this->add_field("name", new RegexField('/^[a-z][a-z0-9_]*$/',[
			"label" => _("Název hodnoty (počítačový)"),
			"max_length" => 255,
			"hints" => [
				"firstname",
				"year_of_birth",
			],
		]));
	
		$this->add_field("required", new BooleanField([
			"label" => _("Povinné políčko?"),
			"required" => false,
			"initial" => true,
		]));

		$this->add_translatable_field("help_text", new TextField([
			"label" => _("Nápověda"),
			"required" => false,
			"help_text" => _("Je možné zadávat HTML značky."),
		]));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if($d && isset($d["class_name"])){
			foreach([
				"\CustomFormFields\HcaptchaField" => ["HCAPTCHA_SITE_KEY","HCAPTCHA_SECRET_KEY"],
				"\CustomFormFields\RecaptchaField" => ["RECAPTCHA_SITE_KEY","RECAPTCHA_SECRET_KEY"],
			] as $f => $constants){
				if($d["class_name"]!==$f){ continue; }
				$c_1 = $constants[0];
				$c_2 = $constants[1];
				if(!defined($c_1) || !defined($c_2) || !constant($c_1) || !constant($c_2)){
					$this->set_error("class_name",sprintf(_("This field cannot be used. Constants %s and %s are not defined properly."),$c_1,$c_2));
				}
			}
		}

		return [$err,$d];
	}
}
