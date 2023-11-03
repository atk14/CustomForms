<?php
class CustomFormFieldChoice extends ApplicationModel implements Translatable, Rankable {

	static function GetTranslatableFields() { return ["title"]; }
	
	function setRank($rank){
		return $this->_setRank($rank,[
			"custom_form_field_id" => $this->g("custom_form_field_id"),
		]);
	}

	function getTitle(){
		$title = parent::getTitle();
		if(!strlen((string)$title)){
			$title = $this->getName();
		}
		return $title;
	}

	function getCustomFormField(){
		return Cache::Get("CustomFormField",$this->getCustomFormFieldId());
	}
}
