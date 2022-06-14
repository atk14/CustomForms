Custom Forms
============

A set of functionality providing forms visually programmable by a user in administration.

Custom Forms are designed for applications built on Atk14Skelet.

Usage
-----

Prerequisites
-------------

### User Authorization

Installation
------------

    cd path/to/your/project/
    composer require atk14/custom-forms

    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/custom_form_data_controller.php app/controllers/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/custom_form_field_choices_controller.php app/controllers/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/custom_form_fields_controller.php app/controllers/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/custom_form_fieldsets_controller.php app/controllers/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/custom_forms_controller.php app/controllers/admin/

    ln -s ../../../vendor/atk14/custom-forms/src/app/controllers/admin/trait_custom_forms_utils.php app/controllers/admin/

    ln -s ../../../vendor/atk14/custom-forms/src/app/forms/admin/custom_form_data app/forms/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/forms/admin/custom_form_field_choices app/forms/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/forms/admin/custom_form_fields app/forms/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/forms/admin/custom_form_fieldsets app/forms/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/forms/admin/custom_forms app/forms/admin/

    ln -s ../../../vendor/atk14/custom-forms/src/app/views/admin/custom_form_data app/views/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/views/admin/custom_form_field_choices app/views/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/views/admin/custom_form_fields app/views/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/views/admin/custom_form_fieldsets app/views/admin/
    ln -s ../../../vendor/atk14/custom-forms/src/app/views/admin/custom_forms app/views/admin/

    ln -s ../../vendor/atk14/custom-forms/src/app/controllers/custom_form_data_files_controller.php app/controllers/
    ln -s ../../vendor/atk14/custom-forms/src/app/controllers/custom_forms_controller.php app/controllers/

    ln -s ../../vendor/atk14/custom-forms/src/app/forms/custom_forms app/forms/

    ln -s ../../vendor/atk14/custom-forms/src/app/views/custom_forms app/views/

    ln -s ../../../vendor/atk14/custom-forms/src/app/views/mailer/notify_custom_form_submission.html.tpl app/views/mailer/

    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form_data_file.php app/models/
    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form_data.php app/models/
    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form_field_choice.php app/models/
    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form_field.php app/models/
    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form_fieldset.php app/models/
    ln -s ../../vendor/atk14/custom-forms/src/app/models/custom_form.php app/models/

    ln -s ../../vendor/atk14/custom-forms/src/app/fields/custom_form_fieldset_field.php app/fields/
    ln -s ../../vendor/atk14/custom-forms/src/app/fields/custom_form_choice_field.php app/fields/
    ln -s ../../vendor/atk14/custom-forms/src/app/fields/custom_form_fields app/fields/

    ln -s ../../vendor/atk14/custom-forms/src/app/widgets/custom_form_widgets app/widgets/

    ln -s ../../vendor/atk14/custom-forms/src/config/routers/custom_forms_router.php ./config/routers/

    ln -s ../../vendor/atk14/emails-field/src/app/fields/emails_field.php app/fields/emails_field.php


Copy migrations files to your project. The leading numbered sequences can be optionally changed, but it's better to preserve them in order to tracking changes in future versions of the Custom Forms.

    cp vendor/atk14/custom-forms/src/db/migrations/0145_custom_forms.sql db/migrations/
    cp vendor/atk14/custom-forms/src/db/migrations/0146_adding_custom_form_id_to_pages.sql db/migrations/
    cp vendor/atk14/custom-forms/src/db/migrations/0147_adding_contact_form_migration.php db/migrations/

There is a couple of things needed to be merged manually.
  
    // file: app/controllers/admin/admin.php
    $items = array(
      array(_("Welcome screen"),         "main"),
      array(_("Articles"),               "articles"),
      array(_("Pages"),                  "pages"),
      array(_("Link Lists"),             "link_lists,link_list_items"),
      array(_("Custom forms"),           "custom_forms,custom_form_fieldsets,custom_form_fields,custom_form_field_choices,custom_form_data"),
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
        // ... after adding the field parent_page_id
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

    {* file: app/views/pages/detail.tpl *}
    {if $page->getCustomForm()}
       {render_component controller="custom_forms" action="detail" id=$page->getCustomForm()}
    {/if}

Edit config/routers/load.php and add the instruction for load the CustomFormsRouter:

    Atk14Url::AddRouter("CustomFormsRouter");

Configuration
-------------

To use reCaptcha field, the constants RECAPTCHA_SITE_KEY and RECAPTCHA_SECRET_KEY must to be defined. See https://packagist.org/packages/atk14/recaptcha-field.

To use hCaptcha field, the constants HCAPTCHA_SITE_KEY and HCAPTCHA_SECRET_KEY must be defined. See https://packagist.org/packages/atk14/hcaptcha-field.

[//]: # ( vim: set ts=2 et: )
