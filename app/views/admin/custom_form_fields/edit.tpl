<h1>{$page_title}</h1>

{render partial="shared/form"}

{if $custom_form_field->choicesRequired()}

	<hr>

	{render_component controller="custom_form_field_choices" action="index" custom_form_field_id=$custom_form_field}

{/if}
