<?php
class CustomFormDataFilesController extends ApplicationController {

	use TraitCustomFormDataFilesController;

	function _is_admin_logged_in(){
		return $this->logged_user && $this->logged_user->isAdmin();
	}
}
