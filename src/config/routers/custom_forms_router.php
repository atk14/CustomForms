<?php
class CustomFormsRouter extends Atk14Router {

	function setUp(){
		// e.g. /custom-form-files/2.7c4ab5e779b49d3/curriculum_vitae.pdf
		$this->addRoute("/custom-form-files/<token>/<filename>","$this->default_lang/custom_form_data_files/detail");
	}
}
