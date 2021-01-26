<li class="list-group-item" data-id="{$choice->getId()}">

	<div class="float-left">
		{$choice->getTitle()}
		<br>
		<small>{$choice->getName()}</small>
	</div>
	
	{dropdown_menu}
		{a action=edit id=$choice}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
		{a_destroy id=$choice}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
	{/dropdown_menu}
</li>
