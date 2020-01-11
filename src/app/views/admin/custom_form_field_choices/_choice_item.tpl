<li class="list-group-item" data-id="{$choice->getId()}">

	{$choice->getName()} <em>{$choice->getTitle()}</em>
	
	{dropdown_menu}
		{a action=edit id=$choice}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
		{a_destroy id=$choice}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
	{/dropdown_menu}
</li>
