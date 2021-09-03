{if !$finder->isEmpty()}
	{dropdown_menu clearfix=false}
		{a action="bulk_destroy" custom_form_id=$custom_form}{!"remove"|icon} {t}Smazat všechny záznamy{/t}{/a}
	{/dropdown_menu}
{/if}

<h1>{$page_title}</h1>

{if $finder->isEmpty()}

	<p>{t}Žádný záznam nebyl nalezen.{/t}</p>

{else}

	{form _class="form-search"}
		{!$form.page_title}&nbsp;
		<button type='submit' class='btn btn-outline-primary' >{t}Hledat{/t}</button>&nbsp;
		<button type='submit' class='btn btn-outline-primary' name='format' value='csv'>{t}Export do CSV{/t}</button>&nbsp;
		<button type='submit' class='btn btn-outline-primary' name='format' value='xls'>{t}Export do Excelu{/t}</button>
	{/form}

	<table class="table table-sm table-striped">
		<thead>
			<tr class="table-dark">
				{sortable key=id}<th class="item-id">#</th>{/sortable}
				{sortable key=page_title}<th>{t}Název stránky{/t}</th>{/sortable}
				<th>{t no=1}Hodnota %1{/t}</th>
				<th>{t no=2}Hodnota %1{/t}</th>
				<th>{t no=3}Hodnota %1{/t}</th>
				<th>{t}Přijato z adresy{/t}</th>
				{sortable key=created_at}<th>{t}Datum{/t}</th>{/sortable}
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial="custom_form_data_item" from=$finder->getRecords()}
		</tbody>
	</table>

	{paginator}

{/if}
