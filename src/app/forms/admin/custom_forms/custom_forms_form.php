<?php
class CustomFormsForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("title", new CharField([
			"label" => _("Název"),
			"max_length" => 255,
		]));

		$this->add_field("visible", new BooleanField([
			"label" => _("Je formulář viditelný?"),
			"required" => false,
			"initial" => true,
		]));

		$this->add_translatable_field("button_text", new CharField([
			"label" => _("Text na odesílacím tlačítku"),
			"max_length" => 255,
		]));

		$this->set_initial([
			"button_text_cs" => "Odeslat",
			"button_text_en" => "Submit",
			"button_text_sk" => "Odoslať"
		]);

		$this->add_field("notify_to_email", new EmailsField([
			"label" => _("Notifikovat odeslání formuláře na e-mail"),
			"max_length" => 255,
			"required" => false,
			"help_text" => _("Je možné zadat více e-mailových adres oddělených čárkou."),
		]));

		$this->add_translatable_field("notification_subject_pattern", new CharField([
			"label" => _("Subjekt notifikační zprávy"),
			"max_length" => 255,
			"required" => false,
			"null_empty_output" => true,
		]));

		$this->add_translatable_field("finish_message", new MarkdownField([
			"label" => _("Text zobrazený po odeslání formuláře"),
			"required" => false,
		]));

		$this->add_field("code", new CharField([
			"label" => _("Unikátní identikační kód formuláře"),
			"null_empty_output" => true,
			"max_length" => 255,
			"required" => false,
			"help_text" => _("Pokud si nejste jisti, ponechte toto pole beze změny."),
		]));
	}
}
