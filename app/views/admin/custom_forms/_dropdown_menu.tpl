{dropdown_menu}
	{if $action=="index"}
		{a action=edit id=$custom_form}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
	{/if}
	{a namespace="" action="custom_forms/detail" id=$custom_form}{!"eye-open"|icon} {t}Náhled formuláře{/t}{/a}
	{a action="custom_form_data/index" custom_form_id=$custom_form}{!"list"|icon} {t}Data{/t}{/a}
	{if $action=="index"}
		{if $custom_form->isDeletable()}
			{a_destroy id=$custom_form}{!"trash-alt"|icon} {t}Smazat formulář{/t}{/a_destroy}
		{/if}
	{/if}
{/dropdown_menu}
