<tr>
	<td>{$custom_form->getId()}</td>
	<td>{$custom_form->getTitle()}</td>
	<td>{$custom_form->getNotifyToEmail()|default:$mdash}</td>
	<td>{$custom_form->getCreatedAt()|format_datetime}</td>
	<td>
		{assign data CustomFormData::FindFirst("custom_form_id",$custom_form,["order_by" => "created_at DESC"])}
		{if $data}
			{a action="custom_form_data/detail" id=$data}{$data->getCreatedAt()|format_datetime}{/a}
		{else}
			&mdash;
		{/if}
	</td>
	<td>
		{render partial="dropdown_menu"}
	</td>
</tr>
