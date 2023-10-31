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

		$dirs = [
			ATK14_DOCUMENT_ROOT."/app/fields/custom_form_fields",
			ATK14_DOCUMENT_ROOT."/app/fields/local_custom_form_fields",
		];
		foreach($dirs as $dir){
			if(!file_exists($dir)){ continue; }
			$handle = opendir($dir);
			while($item = readdir($handle)){
				if(!preg_match('/\.php$/',$item)){ continue; }
				$filename = "$dir/$item";
				$namespace = String4::ToObject($dir)->gsub('/^.+\//','')->camelize()->toString(); // "/home/tiger/webapps/app/fields/custom_form_fields" -> "CustomFormFields"
				$class_name = String4::ToObject($item)->gsub('/\.php$/','')->camelize()->prepend("\\$namespace\\")->toString(); // "\CustomFormFields\CharField"

				if(!class_exists($class_name)){ continue; } // hmmm... neco podivneho to je :)

				// nacteni popisu primo ze souboru - z poznamky
				$name = $class_name;
				$content = Files::GetFileContent($filename);
				if(preg_match('/^.+?\/\*{1,2}\s*\n\s*\*(.*?)\n/s',$content,$matches)){
					$name = trim($matches[1]);
					
				}

				$key = "$name $class_name";

				$out[$key] = [
					"class_name" => $class_name,
					"name" => $name
				];
			}
			closedir($handle);
		}

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
