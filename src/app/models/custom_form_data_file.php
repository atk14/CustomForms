<?php
class CustomFormDataFile extends ApplicationModel {

	function __construct(){
		parent::__construct([
			"do_not_read_values" => ["body"]
		]);
	}

	function getUrl(){
		global $ATK14_GLOBAL;

		$controller = String4::ToObject(get_class($this))->pluralize()->underscore()->toString(); // "Attachment" -> "attachments"

		return Atk14Url::BuildLink(array(
			"namespace" => "",
			"controller" => "custom_form_data_files",
			"lang" => $ATK14_GLOBAL->getDefaultLang(),
			"action" => "detail",
			"token" => $this->getToken(array("hash_length" => 15, "extra_salt" => "custom_form_data_file")),
			"filename" => $this->getFilename(),
		),array(
			"with_hostname" => true,
			"connector" => "&",
		));
	}
}
