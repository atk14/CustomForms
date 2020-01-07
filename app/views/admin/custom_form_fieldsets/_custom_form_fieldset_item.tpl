<li class="list-group-item" data-id="{$custom_form_fieldset->getId()}">
		{!$custom_form_fieldset->getTitle()|h|default:"<em>{t}bez názvu{/t}</em>"}

		{dropdown_menu}
			{a action="custom_form_fields/create_new" custom_form_fieldset_id=$custom_form_fieldset}{!"plus"|icon} {t}Přidat políčko{/t}{/a}
			{a action=edit id=$custom_form_fieldset}{!"pencil-alt"|icon} {t}Upravit fieldset{/t}{/a}

			{if $custom_form_fieldset->isDeletable()}
				{a_destroy id=$custom_form_fieldset}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}

		{assign fields $custom_form_fieldset->getCustomFormFields()}
		{if $fields}
			<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="custom_form_fields/set_rank"}">
				{foreach $fields as $field}
					<li class="list-group-item" data-id="{$field->getId()}">
						{$field->getName()} <em>{$field->getLabel()}</em>
						{if $field->choicesRequired()}
							<small>({t choices_count=sizeof($field->getChoices())}počet voleb: %1{/t})</small>
						{/if}
						{dropdown_menu}
							{a action="custom_form_fields/edit" id=$field}{!"pencil-alt"|icon} {t}Upravit{/t}{/a}
							{a_destroy action="custom_form_fields/destroy" id=$field}{!"trash-alt"|icon} {t}Smazat{/t}{/a_destroy}
						{/dropdown_menu}
					</li>
				{/foreach}
			</ul>
		{/if}

</li>
