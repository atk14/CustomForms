<?php
class BulkDestroyForm extends AdminForm {

	function set_up(){
		$this->add_field("confirmation", new ConfirmationField([
			"label" => _("Smazání potvrďte zatržením checkboxu"),
		]))->update_messages([
			"required" => _("Bez zatržení checkboxu nebude smazání provedeno"),
		]);

		$this->enable_csrf_protection();

		$this->set_button_text(_("Smazat záznamy"));
	}
}
