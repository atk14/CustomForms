<?php
class CustomFormField extends ApplicationModel implements Translatable, Rankable {

	static function GetTranslatableFields() { return ["label", "help_text"]; }

	function setRank($rank){
		$this->_setRank($rank,[
			"custom_form_fieldset_id" => $this->g("custom_form_fieldset_id")
		]);
	}

	static function GetSupportedFields(){
		$out = [];

		$dir = ATK14_DOCUMENT_ROOT."/app/fields/custom_form_fields";
		$handle = opendir($dir);
		while($item = readdir($handle)){
			if(!preg_match('/\.php$/',$item)){ continue; }
			$filename = "$dir/$item";
			$class_name = String4::ToObject($item)->gsub('/\.php$/','')->camelize()->prepend("\\CustomFormFields\\")->toString(); // "\CustomFormFields\CharField"

			if(!class_exists($class_name)){ continue; } // hmmm... neco podivneho to je :)

			// nacteni popisu primo ze souboru - z poznamky
			$name = $class_name;
			$content = Files::GetFileContent($filename);
			if(preg_match('/^.+?\/\*{1,2}\s*\n\s*\*(.*?)\n/s',$content,$matches)){
				$name = $matches[1];
			}

			$key = "$name $class_name";

			$out[$key] = [
				"class_name" => $class_name,
				"name" => $name
			];
		}
		closedir($handle);

		ksort($out,SORT_STRING);
		$out = array_values($out);

		// TODO: stridit $out podle "name"

		return $out;
	}

	function getCustomFormFieldset(){
		return Cache::Get("CustomFormFieldset",$this->getCustomFormFieldsetId());
	}

	function getCustomForm(){
		return $this->getCustomFormFieldset()->getCustomForm();
	}

	function isRequired(){
		return $this->g("required");
	}

	function choicesRequired(){
		return !!preg_match('/Choice/',$this->getClassName()); // "ChoiceField", "MultipleChoiceField"...
	}

	function getChoices(){
		return CustomFormFieldChoice::FindAll("custom_form_field_id",$this);
	}
}
