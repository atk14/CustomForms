<?php
class AddingContactFormMigration extends ApplicationMigration {

	function up(){
		$form = CustomForm::CreateNewRecord([
			"title_cs" => "Kontaktní zpráva",
			"title_en" => "Contact message",
			"button_text_cs" => "Poslat zprávu",
			"button_text_en" => "Send message",
			"finish_message_cs" => "Zpráva nám byla odeslána. Odpovíme vám, jak nejrychleji umíme.",
			"finish_message_en" => "The message has been sent to us. We will reply as soon as we can.",
			"notify_to_email" => DEFAULT_EMAIL,
		]);

		$fieldset = CustomFormFieldset::CreateNewRecord([
			"custom_form_id" => $form,
		]);

		CustomFormField::CreateNewRecord([
			"custom_form_id" => $form,
			"custom_form_fieldset_id" => $fieldset,
			"class_name" => "\\CustomFormFields\\CharField",
			"name" => "name",
			"label_cs" => "Jméno a příjmení",
			"label_en" => "Name",
		]);

		CustomFormField::CreateNewRecord([
			"custom_form_id" => $form,
			"custom_form_fieldset_id" => $fieldset,
			"class_name" => "\\CustomFormFields\\EmailField",
			"name" => "email",
			"label_cs" => "E-mail",
			"label_en" => "Email",
		]);

		CustomFormField::CreateNewRecord([
			"custom_form_id" => $form,
			"custom_form_fieldset_id" => $fieldset,
			"class_name" => "\\CustomFormFields\\TextField",
			"name" => "message",
			"label_cs" => "Váš dotaz",
			"label_en" => "Your message",
		]);

		// If a contact page is found, the contact form is being assigned to the page
		$contact_page = Page::FindFirst("code","contact");
		if($contact_page){
			$contact_page->s([
				"custom_form_id" => $form,
			]);
		}
	}
}
