<h1>{$page_title}</h1>

<p>{t name=$custom_form->getTitle()|h escape=no}Opravdu si přejete smazat všechny záznamy z formuláře <em>%1</em>?{/t}</p>

{render partial="shared/form"}
