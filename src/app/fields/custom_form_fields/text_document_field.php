<?php
namespace CustomFormFields;

/**
 * Text document (file pdf, docx, odt or doc)
 *
 * cs: Textový dokument (soubor pdf, docx, odt nebo doc)
 */
class TextDocumentField extends \FileField {

	function __construct($options = []){

		$options += [
			"allowed_mime_types" => [
				"application/pdf",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document", // docx
				"application/vnd.oasis.opendocument.text", // odt
				"application/msword", // doc
			],
			"max_file_size" => "5M",
		];

		parent::__construct($options);
	}
}
