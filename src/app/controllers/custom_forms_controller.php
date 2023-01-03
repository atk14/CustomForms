<?php
class CustomFormsController extends ApplicationController {

	use TraitCustomFormsController;

	function _after_custom_form_data_creation($custom_form_data){
		return $custom_form_data;
	}

	function _after_notification($custom_form_data){
	}
}
