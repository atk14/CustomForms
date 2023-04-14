<?php
/**
 * Inserts CustomForm into the Markdown text
 *
 * This helper acts as a shortcode for DrinkMarkdown (see https://packagist.org/packages/atk14/drink-markdown)
 *
 * Usage:
 *
 *	Lorem Ipsum...
 *
 *	[custom_form id=123]
 *
 *  Lorem Ipsum...
 */
function smarty_function_drink_shortcode__custom_form($params, $template) {
	$params += [
		"id" => null,
	];

	$id = isset($params["id"]) ? (int)$params["id"] : null;

	$custom_form = CustomForm::GetInstanceById($id);

	if(!$custom_form){
		return sprintf('<div class="bg-warning text-danger">CustomForm with id=%s was not found</div>',$id);
	}

	Atk14Require::Helper("function.render_component");
	return smarty_function_render_component([
		"namespace" => "",
		"controller" => "custom_forms",
		"action" => "detail",
		"id" => $custom_form->getId(),
		"page_title" => "",
	],$template);
}
