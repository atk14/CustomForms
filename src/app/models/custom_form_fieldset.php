<?php
class CustomFormFieldset extends ApplicationModel implements Translatable, Rankable {
	
	static function GetTranslatableFields() { return ["title", "description"]; }

	function setRank($rank){
		$this->_setRank($rank,[
			"custom_form_id" => $this->g("custom_form_id")
		]);
	}

	function getCustomFormFields(){ return CustomFormField::FindAll("custom_form_fieldset_id",$this); }

	function getFields(){ return $this->getCustomFormFields(); }

	function getCustomForm(){ return Cache::Get("CustomForm",$this->getCustomFormId()); }

	function isDeletable(){
		return sizeof($this->getCustomFormFields())==0;
	}
}
