<?php
trait TraitCustomFormsController {

	var $custom_form_data_just_created = null;

	function detail(){
		global $ATK14_GLOBAL;

		if(!$this->rendering_component && !$this->_is_admin_logged_in()){
			// custom formulare se zobrazuji na jinych strankach pomoci render_component
			return $this->_execute_action("error404");
		}

		if(!$this->custom_form->isVisible() && !$this->_is_admin_logged_in()){
			$this->render_template = false;
			return;
		}

		if($this->params->defined("cfd_token")){
			return $this->_execute_action("form_submitted");
		}

		$this->page_title = $this->custom_form->getTitle();
		if($this->params->defined("page_title")){
			// v rezimu render_component je nazev stranky predan parametrem
			$this->page_title = $this->params->getString("page_title");
		}

		$this->form->prepare_for_custom_form($this->custom_form);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->_after_form_validation($d);
			if($this->form->has_errors()){
				return;
			}

			// Checking max form submissions from the same remote address
			$MINUTES_LIMIT = 2;
			$SUBMISSIONS_LIMIT = 5;
			$submissions = CustomFormData::FindAll([
				"conditions" => [
					"created_from_addr=:remote_addr", 
					"created_at>=:limit_date"
				],
				"bind_ar" => [
					":remote_addr" => $this->request->getRemoteAddr(),
					":limit_date" => date("Y-m-d H:i:s",time() - 60 * $MINUTES_LIMIT),
				],
				"limit" => $SUBMISSIONS_LIMIT + 1,
			]);
			if(sizeof($submissions)>=$SUBMISSIONS_LIMIT){
				trigger_error("CustomFormsController: max submissions reached ($SUBMISSIONS_LIMIT) from IP address ".$this->request->getRemoteAddr());
				$this->form->set_error("Bylo dosaženo maximálního počtu odeslání formuláře z jedné IP adresy. Chvíli vyčkejte a odešlete formulář znovu.");
				return;
			}

			$files = [];
			foreach($d as $k => $v){
				if(is_a($v,"HTTPUploadedFile")){
					$file = CustomFormDataFile::CreateNewRecord([
						"name" => $k,
						"filename" => $v->getFileName(["sanitize" => true]),
						"filesize" => $v->getFileSize(),
						"mime_type" => $v->getMimeType(),
						"body" => base64_encode($v->getContent()),
					]);
					$d[$k] = $file->getUrl();
					$files[] = $file;
				}
			}

			$cfd = CustomFormData::CreateNewRecord([
				"custom_form_id" => $this->custom_form,
				"url" => substr($this->request->getUrl(),0,255), // TODO: It should be 2048 or more, see db/migrations/0145_custom_forms.sql
				"page_title" => $this->page_title,
				"data" => json_encode($d),
			]);
			foreach($files as $file){
				$file->s("custom_form_data_id",$cfd);
			}

			$cfd = $this->_after_custom_form_data_creation($cfd);

			if($this->custom_form->getNotifyToEmail()){
				$def_lang = $ATK14_GLOBAL->getDefaultLang();
				$curr_lang = Atk14Locale::Initialize($def_lang);
				$this->mailer->notify_custom_form_submission($cfd);
				Atk14Locale::Initialize($curr_lang);
			}

			$this->_after_notification($cfd);

			$this->custom_form_data_just_created = $cfd;

			$url = $cfd->getUrl();
			$url .= strpos($url,'?') ? '&' : '?';
			$url .= "cfd_token=".$cfd->getToken();
			$this->_redirect_to($url);
		}
	}

	function form_submitted(){
		$custom_form_data = CustomFormData::GetInstanceByToken($this->params->getString("cfd_token"));
		if(!$custom_form_data || $custom_form_data->getCustomFormId()!==$this->custom_form->getId()){
			// removing parameter cfd_token from the URL
			$url = $this->request->getUrl();
			$url = preg_replace('/([?&])cfd_token=[^&]*&?/','\1',$url);
			$url = preg_replace('/[&?]$/','',$url);
			$url = preg_replace('/\?&/','?',$url);
			$this->_redirect_to($url);
			return;
		}

		if(strtotime($custom_form_data->getCreatedAt())<(time() - 60 * 15)){
			// 15 minut stara zprava -> uzivatele uz presmerujeme na puvodni stranku
			return $this->_redirect_to($custom_form_data->getUrl(),["moved_permanently" => true]);
		}

		$this->page_title = $this->custom_form->getTitle();

		$this->tpl_data["custom_form_data"] = $custom_form_data;
	}

	function _before_filter(){
		$cf = $this->_find("custom_form");
		if(!$cf){ return; }

		$this->breadcrumbs[] = $cf->getTitle();
	}

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

	function _is_admin_logged_in(){
		return $this->logged_user && $this->logged_user->isAdmin();
	}
}
