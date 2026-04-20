<div id="custom_form">

{if $custom_form->isTitleVisible()}
<h2>{$custom_form->getTitle()}</h2>
{/if}

{admin_menu for=$custom_form}

<div class="alert alert-success">
	{if $custom_form->getFinishMessage()|trim}
		{!$custom_form->getFinishMessage()|markdown}
	{else}
		<p>
			{t}Formulář byl úspěšně odeslán.{/t}<br>
			{t}Děkujeme.{/t}
		</p>
	{/if}
</div>

</div>
