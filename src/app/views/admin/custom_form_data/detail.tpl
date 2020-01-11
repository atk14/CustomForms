{assign custom_form $custom_form_data->getCustomForm()}

<h1>{$page_title}</h1>

<dl class="dl-horizontal">
	<dt>#</dt>
	<dd>{$custom_form_data->getId()}</dd>

	<dt>{t}Formulář{/t}</dt>
	<dd>{a action="custom_forms/edit" id=$custom_form}{$custom_form->getTitle()}{/a}</dd>

	<dt>{t}Datum přijetí{/t}</dt>
	<dd>{$custom_form_data->getCreatedAt()|format_datetime}</dd>

	<dt>{t}Přijato ze stránky{/t}</dt>
	<dd><a href="{$custom_form_data->getUrl()}">{$custom_form_data->getPageTitle()|default:$mdash}</a></dd>

	<dt>{t}Přihlášený uživatel{/t}</dt>
	<dd>{$custom_form_data->getCreatedByUser()|user_name|default:$mdash}</dd>

	<dt>{t}Přijato z adresy{/t}</dt>
	<dd>{$custom_form_data->getCreatedFromHostname()} ({$custom_form_data->getCreatedFromAddr()})</dd>

	<dt>{t}Přijato z prohlížeče{/t}</dt>
	<dd>{$custom_form_data->getCreatedFromUserAgent()}</dd>
</dl>

<h3>{t}Zaslaná data{/t}</h3>

<dl class="dl-horizontal">
	{foreach $data as $key => $value}
		<dt>{$key}</dt>
		<dd>{dump var=$value}</dd>
	{/foreach}
</dl>
