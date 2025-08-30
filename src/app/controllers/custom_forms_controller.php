<?php
class CustomFormsController extends ApplicationController {

	// see vendor/atk14/custom-forms/src/lib/trait_custom_forms_controller.php
	use TraitCustomFormsController;

	// Process hooks

	function _after_form_validation(&$d){
		// if( $something_bad ){
		//	$this->form->set_error("Change something and do it again");
		// }
	}

	function _after_custom_form_data_creation($custom_form_data){
		return $custom_form_data;
	}

	function _after_notification($custom_form_data){
	}

	function _is_admin_access_granted(){
		return $this->logged_user && $this->logged_user->isAdmin();
	}
}
