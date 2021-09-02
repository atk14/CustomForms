<?php
class CustomForm extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() { return ["title", "description", "button_text", "finish_message"]; }

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
