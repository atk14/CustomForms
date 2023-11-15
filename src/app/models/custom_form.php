<?php
class CustomForm extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() { return ["title", "description", "button_text", "finish_message", "notification_subject_pattern", "sender_name_pattern"]; }

	function getCustomFormFieldsets(){
		return CustomFormFieldset::FindAll("custom_form_id",$this);
	}

	function getFieldsets(){
		return $this->getCustomFormFieldsets();
	}

	function getCustomFormFields(){
		$fields = [];
		foreach($this->getCustomFormFieldsets() as $fieldset){
			foreach($fieldset->getCustomFormFields() as $field){
				$fields[] = $field;
			}
		}
		return $fields;
	}

	function getFields(){
		return $this->getCustomFormFields();
	}

	/**
	 *
	 *	$subject_pattern = $custom_form->getNotificationSubjectPattern();
	 *	$subject_pattern = $custom_form->getNotificationSubjectPattern("en");
	 *	$subject_pattern = $custom_form->getNotificationSubjectPattern("en",["fallback_pattern" => "Form submission at %page_title%");
	 *	$subject_pattern = $custom_form->getNotificationSubjectPattern(["fallback_pattern" => "Form submission at %page_title%"]);
	 */
	function getNotificationSubjectPattern($lang = null, $options = []){
		if(is_array($lang)){
			$options = $lang;
			$lang = null;
		}
		$options += [
			"fallback_pattern" => _("Odeslání formuláře %form_title% ze stránky %page_title%"),
		];

		$out = parent::getNotificationSubjectPattern($lang);
		if(!strlen((string)$out)){
			$out = $options["fallback_pattern"];
		}

		return $out;
	}

	/**
	 *
	 *	#subject = $custom_form->getNotificationSubject($custom_form_data);
	 *	#subject = $custom_form->getNotificationSubject($custom_form_data,["fallback_pattern" => "Form submission at %page_title%"]);
	 */
	function getNotificationSubject(CustomFormData $custom_form_data,$options = []){
		$subject = $this->getNotificationSubjectPattern($options);
		$subject = strtr($subject,[
			"%form_title%" => $this->getTitle(),
			"%page_title%" => $custom_form_data->getPageTitle()
		]);
		return $subject;
	}

	/**
	 *
	 *	$subject_pattern = $custom_form->getSenderNamePattern();
	 *	$subject_pattern = $custom_form->getSenderNamePattern("en");
	 *	$subject_pattern = $custom_form->getSenderNamePattern("en",["fallback_pattern" => "Form submission at %page_title%");
	 *	$subject_pattern = $custom_form->getSenderNamePattern(["fallback_pattern" => "Form submission at %page_title%"]);
	 */
	function getSenderNamePattern($lang = null, $options = []){
		if(is_array($lang)){
			$options = $lang;
			$lang = null;
		}
		$options += [
			"fallback_pattern" => ATK14_APPLICATION_NAME,
		];

		$out = parent::getSenderNamePattern($lang);
		if(!strlen((string)$out)){
			$out = $options["fallback_pattern"];
		}

		return $out;
	}

	/**
	 *
	 *	#subject = $custom_form->getSenderName($custom_form_data);
	 *	#subject = $custom_form->getSenderName($custom_form_data,["fallback_pattern" => "Form submission at %page_title%"]);
	 */
	function getSenderName(CustomFormData $custom_form_data,$options = []){
		$subject = $this->getSenderNamePattern($options);
		$subject = strtr($subject,[
			"%form_title%" => $this->getTitle(),
			"%page_title%" => $custom_form_data->getPageTitle()
		]);
		return $subject;
	}

	function isVisible(){
		return $this->g("visible");
	}

	function getCountOfDataRecords(){
		return $this->dbmole->selectInt("SELECT COUNT(*) FROM custom_form_data WHERE custom_form_id=:custom_form",[":custom_form" => $this]);
	}

	function isDeletable(){
		foreach(["custom_form_data","pages"] as $table){
			$cnt = $this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM $table WHERE custom_form_id=:custom_form LIMIT 1)q",[":custom_form" => $this]);
			if($cnt>0){ return false; }
		}
		return true;
	}
}
