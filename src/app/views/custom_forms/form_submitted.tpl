<div id="custom_form">

<h2>{$custom_form->getTitle()}</h2>

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
