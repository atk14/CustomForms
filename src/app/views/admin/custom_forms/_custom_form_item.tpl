<tr>
	<td>{$custom_form->getId()}</td>
	<td>{$custom_form->getTitle()}</td>
	<td>{$custom_form->getNotifyToEmail()|default:$mdash}</td>
	<td>{$custom_form->getCode()|default:$mdash}</td>
	<td>
		{if $custom_form->getCountOfDataRecords()}
			{a action="custom_form_data/index" custom_form_id=$custom_form}{$custom_form->getCountOfDataRecords()}{/a}
		{else}
			0
		{/if}
	</td>
	<td>
		{assign data CustomFormData::FindFirst("custom_form_id",$custom_form,["order_by" => "created_at DESC"])}
		{if $data}
			{a action="custom_form_data/detail" id=$data}{$data->getCreatedAt()|format_datetime}{/a}
		{else}
			&mdash;
		{/if}
	</td>
	<td>{$custom_form->getCreatedAt()|format_datetime}</td>
	<td>
		{render partial="dropdown_menu"}
	</td>
</tr>
