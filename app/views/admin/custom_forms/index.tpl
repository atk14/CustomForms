<h1>{button_create_new}{/button_create_new} {$page_title}</h1>

{if $finder->isEmpty()}

	<p>{t}Žadný formulář nebyl nalezen.{/t}</p>

{else}

	
	<table class="table table-sm table-striped table--articles">
		<thead>
			<tr class="table-dark">
				{sortable key=id}<th class="item-id">#</th>{/sortable}
				{sortable key=title}<th class="item-title">{t}Title{/t}</th>{/sortable}
				<th>{t}Notifikovat na e-mail{/t}</th>
				{sortable key=created_at}<th class="item-published">{t}Datum vytvoření{/t}</th>{/sortable}
				{sortable key=last_submitted_at}<th>{t}Naposledy odesláno{/t}</th>{/sortable}
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial="custom_form_item" from=$finder->getRecords()}
		</tbody>
	</table>

	{paginator}

{/if}
