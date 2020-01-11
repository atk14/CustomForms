{render partial="dropdown_menu"}

<h1>{$page_title}</h1>

{render partial="shared/form"}

<hr>

{render_component controller="custom_form_fieldsets" custom_form_id=$custom_form}
