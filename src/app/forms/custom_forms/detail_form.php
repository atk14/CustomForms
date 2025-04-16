<?php
class DetailForm extends ApplicationForm {

	var $attr_id = "custom_form";

	function set_up(){
		global $HTTP_REQUEST;

		$this->set_hidden_field("cfd_start",$HTTP_REQUEST->getPostVar("cfd_start") ? (string)$HTTP_REQUEST->getPostVar("cfd_start") : Packer::Pack(["cfd_start" => $this->_microtime()]));
	}

	function prepare_for_custom_form($custom_form){
		global $HTTP_REQUEST;

		$fields = $custom_form->getFields();

		$this->set_method("post");
		if($custom_form->getCode()){
			$this->attr_id .= "_".String4::ToObject($custom_form->getCode())->toSlug()->replace("-","_");
		}
		$this->set_attr("id",$this->attr_id);
		$this->set_action($HTTP_REQUEST->getRequestUri()."#".$this->attr_id);
		$this->set_button_text($custom_form->getButtonText());
		if(sizeof($fields)<=5){
			$this->enable_csrf_protection();
		}

		foreach($fields as $field){
			$class_name = $field->getClassName();
			$options = [
				"label" => $field->getLabel(),
				"required" => $field->isRequired(),
			];
			if($field->getHelpText()){
				// the default help_text should be used if there is no specific
				$options["help_text"] = $field->getHelpText();
			}
			if($field->choicesRequired()){
				$choices = [];
				foreach($field->getChoices() as $choice){
					$choices[$choice->getName()] = $choice->getTitle();
				}
				$options["choices"] = $choices;
			}
			$this->add_field($field->getName(),new $class_name($options));
		}
	}

	function clean(){
		global $HTTP_REQUEST;
		list($err,$d) = parent::clean();

		if(!$this->has_errors()){
			$start = $this->_decode_start();
			$current_time = $this->_microtime();

			if(is_null($start) || ($current_time - $start > 60 * 60 * 24)){
				$uri = $HTTP_REQUEST->getRequestUri();
				$uri .= preg_match('/\?/',$uri) ? "&" : "?";
				$uri .= "rnd=".uniqid();
				$this->set_error(
					_("Načtěte formulář ještě jednou, znovu jej vyplňte a odešlete")."<br><br>".
					sprintf('<a href="%s">%s</a>',$uri."#".$this->attr_id,_("Načíst formulář znovu"))
				);
			}

			if($current_time - $start < 5){
				$this->set_error(_("Odešlete prosím formulář ještě jednou"));
			}
		}

		return [$err,$d];
	}

	function _microtime(){
		list($decimals,$time) = explode(" ",microtime());
		$microtime = $time + $decimals;
		return round($microtime,2);
	}

	function _decode_start(){
		global $HTTP_REQUEST;

		if(!Packer::Unpack((string)$HTTP_REQUEST->getPostVar("cfd_start"),$var)){
			return null;
		}

		if(!is_array($var) || !isset($var["cfd_start"])){
			return null;
		}

		return (float)$var["cfd_start"];
	}
}
