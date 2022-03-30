{form _novalidate="novalidate" _class="form-horizontal"}

	{if !$custom_form->isVisible() || !$rendering_component}
		<div class="alert alert-warning" role="alert">
			{if !$custom_form->isVisible()}
				{t}Tento formulář není viditelný pro běžného uživatele.{/t}
			{elseif !$rendering_component}
				{t}Na tomto URL není formulář dostupný běžnému uživateli.{/t}
			{/if}
		</div>
	{/if}

	<h2>{$custom_form->getTitle()}</h2>

	{render partial="shared/form_error"}

	{admin_menu for=$custom_form}

	{foreach $custom_form->getFieldsets() as $fieldset}
		<fieldset>
			{if $fieldset->getTitle()}<legend>{$fieldset->getTitle()}</legend>{/if}
			{!$fieldset->getDescription()|markdown}
			{foreach $fieldset->getFields() as $field}
				{render partial="shared/form_field" field=$field->getName()}
			{/foreach}
		</fieldset>
	{/foreach}

	<fieldset>
		<div class="form-group">
			<span class="button-container">
				<button type="submit" class="btn btn-primary">{$form->get_button_text()}</button>

				{if sizeof($form->fields)>5}{* Up to five fields, the reset button is not displayed *}

				{capture assign=reset_button_text}{t}Vyčistit formulář{/t}{/capture}
				{capture assign=reset_button_confirmation}{t}Skutečně chcete vyčistit formulář?{/t}{/capture}
				{if $request->get()}
					<button type="reset" class="btn btn-warning" onclick="return confirm({h}{jstring}{$reset_button_confirmation}{/jstring}{/h});">{$reset_button_text}</button>
				{else}
					{* Post? Vycisteni vyresime prostym odkazem na pradny formular. *}
					<a href="{$request->getUri()}" class="btn btn-warning" onclick="return confirm({h}{jstring}{$reset_button_text}{/jstring}{/h});">{$reset_button_text}</a>
				{/if}

				{/if}

			</span>
		</div>
	</fieldset>

{/form}
