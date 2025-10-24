<?php
namespace CustomFormFields;

/**
 * Captcha (simple protection)
 *
 * cs: Captcha (jednoduchá ochrana)
 */
class CaptchaField extends \CharField {

	var $question;
	var $answers;
	
	function __construct($options = []){
		$options += [
			"question" => "8 + 5",
			"answers" => ["13"], // there may be more correct answers
		];

		$this->question = $options["question"];
		$this->answers = $options["answers"];

		$options += [
			"help_text" => sprintf(_("Vyřešte prosím příklad <em>%s</em>. Jedná se o ochranu před robotickým zneužitím tohoto formuláře."),$this->question),
		];

		parent::__construct($options);
		
		$this->widget->attrs["placeholder"] = "$this->question =";

		$this->update_message("invalid_answer",_("Toto není správná odpověď."));
	}

	function clean($value){
		list($err,$value) = parent::clean($value);

		if($err || is_null($value)){ return [$err,$value]; }

		if(!in_array($value,$this->answers)){
			return [$this->messages["invalid_answer"], null];
		}

		$value = "passed ($this->question = $value)";

		return [$err,$value];
	}
}
