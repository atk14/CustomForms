<tr>
	<td>{$custom_form_data->getId()}</td>
	<td>{$custom_form_data->getPageTitle()}</td>
	<td>{$custom_form_data->getCreatedFromHostname()}</td>
	<td>{$custom_form_data->getCreatedAt()|format_datetime}</td>
	<td>
		{dropdown_menu}
			{a action="detail" id=$custom_form_data}{!"eye"|icon} {t}Detail{/t}{/a}
			{a_destroy id=$custom_form_data}{!"trash"|icon} {t}Delete{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
