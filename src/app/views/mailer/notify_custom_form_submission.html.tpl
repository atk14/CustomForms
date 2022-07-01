{t title=$custom_form->getTitle()}Data z formuláře %1{/t}<br/>
<br/>

<strong>{t}Název formulář{/t}:</strong><br/>
{$custom_form->getTitle()}<br/>
<strong>{t}Datum přijetí{/t}:</strong><br/>
{$custom_form_data->getCreatedAt()|format_datetime}<br/>
<strong>{t}Přijato ze stránky{/t}:</strong><br/>
{$custom_form_data->getPageTitle()} ({$custom_form_data->getUrl()})<br/>
<strong>{t}Přihlášený uživatel{/t}:</strong><br/>
{$custom_form_data->getCreatedByUser()|user_name|default:"-"}<br/>
<strong>{t}Přijato z adresy{/t}:</strong><br/>
{$custom_form_data->getCreatedFromHostname()}{if $custom_form_data->getCreatedFromHostname()!=$custom_form_data->getCreatedFromAddr()} ({$custom_form_data->getCreatedFromAddr()}){/if}<br/>
<strong>{t}Přijato z prohlížeče{/t}:</strong><br/>
{$custom_form_data->getCreatedFromUserAgent()}<br/>
<br/>

{t}Zaslaná data{/t}<br/>
<br/>

{foreach $data as $key => $value}
<strong>{$key}:</strong><br/>
	{if is_bool($value)}
		{$value|display_bool}
	{elseif is_array($value)}
		{to_sentence var=$value}
	{else}
		{!$value|h|nl2br|default:"-"}
	{/if}<br/>
{/foreach}
