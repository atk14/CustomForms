<h3 id="list_of_choices">{button_create_new action="create_new" custom_form_field_id=$custom_form_field return_to_anchor=list_of_choices}{t}Přidat novou volbu{/t}{/button_create_new} {$page_title}</h3>

{if $choices}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{foreach $choices as $choice}
			{render partial="choice_item"}
		{/foreach}
	</ul>

{else}

	<p>{t}Momentalně tady není žádná volba.{/t}</p>

{/if}
