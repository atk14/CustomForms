<?php
trait TraitCustomFormDataFilesController {

	function detail(){
		// Detail souboru je dostupny pouze prihlasenemu administratorovi
		if(!$this->_is_admin_logged_in()){
			return $this->_execute_action("error403");
		}

		$token = $this->params->getString("token");
		$file = CustomFormDataFile::GetInstanceByToken($token,array("hash_length" => 15, "extra_salt" => "custom_form_data_file"));
		if(!$file || $file->getFilename()!==$this->params->getString("filename")){
			$this->_execute_action("error404");
			return;
		}

		$this->render_template = false;
		$this->response->setContentType($file->getMimeType());
		$this->response->setHeader(sprintf('Content-Disposition: attachment; filename="%s"',h($file->getFilename())));
		$this->response->write(base64_decode($file->getBody()));
	}

	function _is_admin_logged_in(){
		return $this->logged_user && $this->logged_user->isAdmin();
	}
}
