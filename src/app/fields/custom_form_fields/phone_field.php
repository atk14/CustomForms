<?php
namespace CustomFormFields;

/**
 * Telefonní číslo
 */
class PhoneField extends \PhoneField {

	function __construct($options = []){

		$default_country_code = defined("ACTIVA_CORP_SK") && ACTIVA_CORP_SK ? "+421" : "+420";

		$options += [
			"default_country_code" => $default_country_code,
		];

		parent::__construct($options);
	}
}
