{assign data $custom_form_data->getDataAsArray()}
{assign keys $data|array_keys}
{assign values $data|array_values}

<tr>
	<td>{$custom_form_data->getId()}</td>
	<td>{$custom_form_data->getPageTitle()|default:$mdash}</td>
	{for $i=0 to 2}
		<td>
			{if $keys.$i}
				<small>{$keys.$i}</small><br>
				{$values.$i|truncate:50}
			{else}
				&mdash;
			{/if}
		</td>
	{/for}
	<td>{$custom_form_data->getCreatedFromHostname()}</td>
	<td>{$custom_form_data->getCreatedAt()|format_datetime}</td>
	<td>
		{dropdown_menu}
			{a action="detail" id=$custom_form_data}{!"eye"|icon} {t}Detail{/t}{/a}
			{a_destroy id=$custom_form_data}{!"trash"|icon} {t}Delete{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
