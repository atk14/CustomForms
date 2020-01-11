<h2>{t title=$custom_form->getTitle()}Data z formuláře %1{/t}</h2>

<ul>
	<li>
		<strong>{t}Název formulář{/t}:</strong><br>
		{$custom_form->getTitle()}
	</li>
	<li>
		<strong>{t}Datum přijetí{/t}:</strong><br>
		{$custom_form_data->getCreatedAt()|format_datetime}
	</li>
	<li>
		<strong>{t}Přijato ze stránky{/t}:</strong><br>
		{$custom_form_data->getPageTitle()} (<a href="{$custom_form_data->getUrl()}">{$custom_form_data->getUrl()}</a>)
	</li>
	<li>
		<strong>{t}Přihlášený uživatel{/t}:</strong>
		{$custom_form_data->getCreatedByUser()|user_name|default:$mdash}
	</li>
	<li>
		<strong>{t}Přijato z adresy{/t}:</strong><br>
		{$custom_form_data->getCreatedFromHostname()} ({$custom_form_data->getCreatedFromAddr()})
	</li>
	<li>
		<strong>{t}Přijato z prohlížeče{/t}:</strong><br>
		{$custom_form_data->getCreatedFromUserAgent()}
	</li>
</ul>

<h4>{t}Zaslaná data{/t}</h4>

<ul>
	{foreach $data as $key => $value}
	<li>
	<strong>{$key}:</strong><br>
		{if is_bool($value)}
			{$value|display_bool}
		{elseif is_array($value)}
			{to_sentence var=$value}
		{else}
			{!$value|h|nl2br|default:$mdash}
		{/if}
	</li>
	{/foreach}
</ul>
