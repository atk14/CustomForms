<h3 id="custom_form_fieldsets">{button_create_new custom_form_id=$custom_form return_to_anchor="custom_form_fieldsets"}{/button_create_new} {$page_title}</h3>

{if $custom_form_fieldsets}

	<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
		{render partial=custom_form_fieldset_item from=$custom_form_fieldsets}
	</ul>

{else}

	<p>{t}Zatím tady není žádný fieldset.{/t}</p>

{/if}
