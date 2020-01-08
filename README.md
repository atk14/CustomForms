Custom Forms
------------

Usage
=====

In a template:

    {* file: app/views/main/index.tpl *}

    {editable key="about_us"}
    <p>We are who we are!</p>
    <p>We are here because we are here!</p>
    {/editable}

By default, editable content is being edited in the textarea (as the DEFAULT_EDITABLE_CONTENT_TYPE is set as "text").

Other ways of usage:

    {editable_string key="about_us/title"}About Us{/editable_string}

    {editable_markdown key="about_us"}
    * We are who we are!
    * We are here because we are here!
    {/editable_markdown}

    {editable_render partial="person_info" person=$person key="vip_person"}


    {editable_link_content key="about_us/title"}
      <a  href="{"about_us"|link_to_page}">
        About us
      </a>
    {/editable_link_content}

Prerequisites
=============

### User Authorization

Installation
============

    cd path/to/your/project/
    git submodule add git@bitbucket.org:snapps/custom_forms.git lib/custom_forms

    ln -s ../../../lib/custom_forms/app/controllers/admin/custom_form_data_controller.php app/controllers/admin/
    ln -s ../../../lib/custom_forms/app/controllers/admin/custom_form_field_choices_controller.php app/controllers/admin/
    ln -s ../../../lib/custom_forms/app/controllers/admin/custom_form_fields_controller.php app/controllers/admin/
    ln -s ../../../lib/custom_forms/app/controllers/admin/custom_form_fieldsets_controller.php app/controllers/admin/
    ln -s ../../../lib/custom_forms/app/controllers/admin/custom_forms_controller.php app/controllers/admin/

    ln -s ../../../lib/custom_forms/app/controllers/admin/trait_custom_forms_utils.php app/controllers/admin/

    ln -s ../../../lib/custom_forms/app/forms/admin/custom_form_data app/forms/admin/
    ln -s ../../../lib/custom_forms/app/forms/admin/custom_form_field_choices app/forms/admin/
    ln -s ../../../lib/custom_forms/app/forms/admin/custom_form_fields app/forms/admin/
    ln -s ../../../lib/custom_forms/app/forms/admin/custom_form_fieldsets app/forms/admin/
    ln -s ../../../lib/custom_forms/app/forms/admin/custom_forms app/forms/admin/

    ln -s ../../../lib/custom_forms/app/views/admin/custom_form_data app/views/admin/
    ln -s ../../../lib/custom_forms/app/views/admin/custom_form_field_choices app/views/admin/
    ln -s ../../../lib/custom_forms/app/views/admin/custom_form_fields app/views/admin/
    ln -s ../../../lib/custom_forms/app/views/admin/custom_form_fieldsets app/views/admin/
    ln -s ../../../lib/custom_forms/app/views/admin/custom_forms app/views/admin/

    ln -s ../../lib/custom_forms/app/controllers/custom_form_data_files_controller.php app/controllers/
    ln -s ../../lib/custom_forms/app/controllers/custom_forms_controller.php app/controllers/

    ln -s ../../lib/custom_forms/app/forms/custom_forms app/forms/

    ln -s ../../lib/custom_forms/app/views/custom_forms app/views/

		ln -s ../../../lib/custom_forms/app/views/mailer/notify_custom_form_submission.html.tpl app/views/mailer/

    ln -s ../../lib/custom_forms/app/models/custom_form_data_file.php app/models/
    ln -s ../../lib/custom_forms/app/models/custom_form_data.php app/models/
    ln -s ../../lib/custom_forms/app/models/custom_form_field_choice.php app/models/
    ln -s ../../lib/custom_forms/app/models/custom_form_field.php app/models/
    ln -s ../../lib/custom_forms/app/models/custom_form_fieldset.php app/models/
    ln -s ../../lib/custom_forms/app/models/custom_form.php app/models/

    ln -s ../../lib/custom_forms/app/fields/custom_form_fieldset_field.php app/fields/
    ln -s ../../lib/custom_forms/app/fields/custom_form_choice_field.php app/fields/
    ln -s ../../lib/custom_forms/app/fields/custom_form_fields app/fields/

    ln -s ../../lib/custom_forms/app/widgets/custom_form_widgets app/widgets/

    ln -s ../../../lib/custom_forms/app/forms/admin/custom_forms app/forms/admin/
    ln -s ../../../lib/custom_forms/app/views/admin/custom_forms app/views/admin/
    ln -s ../../lib/custom_forms/app/helpers/block.editable.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/block.editable_markdown.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/block.editable_link_content.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/block.editable_page_description.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/block.editable_page_title.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/function.editable_render.php app/helpers/
    ln -s ../../lib/custom_forms/app/helpers/block.editable_string.php app/helpers/
    ln -s ../../lib/custom_forms/app/models/editable_fragment.php app/models/
    ln -s ../../lib/custom_forms/app/models/editable_fragment_history.php app/models/
    ln -s ../../lib/custom_forms/test/models/tc_editable_fragment.php test/models/
    ln -s ../../lib/custom_forms/test/models/tc_editable_fragment_history.php test/models/
    ln -s ../../lib/custom_forms/test/helpers/tc_editable_markdown.php test/helpers/

Copy migration to a proper filename into your project:

    cp lib/custom_forms/db/migrations/0145_custom_forms.sql db/migrations/
    cp lib/custom_forms/db/migrations/0146_adding_custom_form_id_to_pages.sql db/migrations/
    cp lib/custom_forms/db/migrations/0147_adding_contact_form_migration.php db/migrations/

There is a couple of things needed to be merged manually.
	
		// file: app/controllers/admin/admin.php
    $items = array(
      array(_("Welcome screen"),         "main"),
      array(_("Articles"),               "articles"),
      array(_("Pages"),                  "pages"),
      array(_("Link Lists"),             "link_lists,link_list_items"),
      array(_("Forms"),                  "custom_forms,custom_form_fieldsets,custom_form_fields,custom_form_field_choices,custom_form_data"),
      array(_("Tags"),                   "tags"),
      array(_("Password recoveries"),    "password_recoveries"),
      array(_("Newsletter subscribers"), "newsletter_subscribers"),
      array(_("404 Redirections"),       "error_redirections"),
      array(_("Nastavení webu"),         "site_settings"),
    );

		// file: app/controllers/application_mailer.php
		class ApplicationMailer extends Atk14Mailer {

			function notify_custom_form_submission($custom_form_data){
				$custom_form = $custom_form_data->getCustomForm();
				$this->to = $custom_form->getNotifyToEmail();
				$this->subject = strtr(_("Odeslání formáře %form_title% ze stránky %page_title%"),["%form_title%" => $custom_form->getTitle(), "%page_title%" => $custom_form_data->getPageTitle()]);

				$this->tpl_data["custom_form"] = $custom_form;
				$this->tpl_data["custom_form_data"] = $custom_form_data;
				$this->tpl_data["data"] = $custom_form_data->getDataAsArray();
			}
		}

		// file: app/forms/admin/pages/pages_form.php
		class PagesForm extends AdminForm {
			function set_up(){
				$this->add_field("custom_form_id", new CustomFormChoiceField([
					"label" => _("Custom form"),
					"required" => false,
				]));
			}
		}

		// file: app/models/page.php
		class Page extends ApplicationModel implements Translatable, Rankable, iSlug {
			function getCustomForm(){
				return Cache::Get("CustomForm",$this->getCustomFormId());
			}
		}

[//]: # ( vim: set ts=2 et: )
