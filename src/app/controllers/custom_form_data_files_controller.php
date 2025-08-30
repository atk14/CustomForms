<?php
class CustomFormDataFilesController extends ApplicationController {

	use TraitCustomFormDataFilesController;

	function _is_admin_access_granted(){
		return $this->logged_user && $this->logged_user->isAdmin();
	}
}
