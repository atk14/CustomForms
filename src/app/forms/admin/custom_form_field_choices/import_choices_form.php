<?php
class ImportChoicesForm extends CustomFormFieldChoicesForm {

	function set_up(){
		$this->add_field("csv", new TextField([
		]));

		$this->add_field("delete_current_choices", new BooleanField([
			"label" => _("Smazat stávající volby?"),
			"initial" => true,
			"disabled" => true,
		]));

		$this->set_button_text(_("Importovat volby"));
	}

	function clean(){
		global $ATK14_GLOBAL;
		list($err,$d) = parent::clean();

		if(!is_array($d) || !isset($d["csv"])){
			return [$err,$d]; 
		}

		$reader = CsvReader::FromData($d["csv"]);
		$rows = $reader->getAssociativeRows();
		$langs = $ATK14_GLOBAL->getSupportedLangs();
		$MAX_LENGTH = 200;

		$out = [];
		foreach($rows as $row){
			if(!isset($row["name"])){
				$this->set_error("csv",sprintf(_("V CSV datech chybí sloupec %s"),"name"));
				return [$err,$d];
			}
			$name = $row["name"];
			if(isset($out[$name])){
				$this->set_error("csv",sprintf(_('V CSV datech je hodnota "%s"  vícekrát'),h($name)));
				return [$err,$d];
			}
			if(strlen($name)>$MAX_LENGTH){
				$this->set_error("csv",sprintf(_("Žádná hodnota nesmí být delší než %s znaků"),$MAX_LENGTH));
				return [$err,$d];
			}
			$ar = ["name" => $name];
			foreach($langs as $l){
				$title = isset($row["title_$l"]) ? $row["title_$l"] : null;
				if(strlen((string)$title)>$MAX_LENGTH){
					$this->set_error("csv",sprintf(_("Žádná hodnota nesmí být delší než %s znaků"),$MAX_LENGTH));
					return [$err,$d];
				}
				$ar["title_$l"] = $title;
			}
			$out[$name] = $ar;
		}

		if(!$out){
			$this->set_error("csv",_("V CSV datech nebyla rozpoznána žádná volba"));
			return [$err,$d]; 
		}

		$d["csv"] = array_values($out);

		return [$err,$d]; 
	}
}
