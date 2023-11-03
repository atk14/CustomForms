
<h3 id="list_of_choices">
	{button_create_new action="create_new" custom_form_field_id=$custom_form_field return_to_anchor=list_of_choices}{t}Přidat novou volbu{/t}{/button_create_new} {$page_title}
	{capture assign=return_uri}{$request->getUrl()}#list_of_choices{/capture}
	{dropdown_menu}
		{a action="import_choices" custom_form_field_id=$custom_form_field return_uri=$return_uri}{t}Naimportovat volby{/t}{/a}
		{a action="export_choices" custom_form_field_id=$custom_form_field}{t}Vyexportovat volby{/t}{/a}
	{/dropdown_menu}
</h3>

{if $choices}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $choices as $choice}
			{render partial="choice_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}Momentalně tady není žádná volba.{/t}</p>

{/if}
