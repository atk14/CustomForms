<?php
class CustomFormData extends ApplicationModel {

	function __construct(){
		parent::__construct("custom_form_data");
	}

	function getDataAsArray() {
		return json_decode($this->getData(), true);
	}

	function getCustomForm(){
		return Cache::Get("CustomForm",$this->getCustomFormId());
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	/**
	 *	$cfd = CustomFormData::FindAll(.....);
	 *	list($header, $datas) = CustomFormData::DataExport($cfd);
	 *	fputcsv($stream, $header)
	 *	foreach($datas as $d)	{
	 *		fputcsv($stream, $d);
	 *	}
	 **/
	static function DataExport($custom_form_datas, $options = []) {
		$options+= [
			'replace_newline' => false		//can contain newlines
		];
		if($options['replace_newline']===true) {
			$options['replace_newline'] = ' | ';
		}

		$headers = [
			'#',
			_('Datum přijetí'),
			_('Přijato ze stránky'),
			_('Název stránky'),
			_('Přihlášený uživatel'),
			_('Přijato z IP adresy'),
			_('Přijato z adresy'),
			_('Přijato z prohlížeče')
		];
		$fields = [];
		$rows = [];

		foreach($custom_form_datas as $data) {
			$row = [
				$data->getId(),
				date("Y-m-d H:i:s", strtotime($data->getCreatedAt())),
				$data->getUrl(),
				$data->getPageTitle(),
				$data->getCreatedByUser() ? $data->getCreatedByUser()->getLogin() : null,
				$data->getCreatedFromAddr(),
				$data->getCreatedFromHostname(),
				$data->getCreatedFromUserAgent()
			];
			$fdata = $data->getDataAsArray();
			$fdata = array_map(function($v) use($options) {
				if(is_array($v)) { $v=implode("|", $v); };
				if($options['replace_newline'] !== false) {
					$v=mb_ereg_replace("\r?\n", $options['replace_newline'], $v);
				}
				return $v;
			}, $fdata);
			$new = array_diff_key($fdata, $fields);
			$fdata += $fields;
			foreach($fields as $f => $_) {
				$row[] = $fdata[$f];
			}
			$row = array_merge($row, array_values($new));
			$fields += array_fill_keys(array_keys($new),'');
			$rows[] = $row;
		}

		$headers = array_merge($headers, array_keys($fields));
		return [$headers, $rows];
	}
}
