Change Log
==========

All notable changes to Custom Forms project will be documented in this file.

## [0.4.12] - 2022-11-14

* bc1062a - It does not print anything if the custom form is not visible

## [0.4.11] - 2022-10-07

* e5c395e - On the reset button: btn-warning replaced with btn-link

## [0.4.10] - 2022-08-23

* 737184e - Url shortened before saving into the table custom_form_data

## [0.4.9] - 2022-08-11

* 01703a9 - A CustomForm submission should be processed neither too early (5 sec) nor too late (1 day)
* Few fixes

## [0.4.8] - 2022-06-14

* e4e8bec - Added CustomFormFields\ImageField - field for uploading an image
* 5dd866b - Added CustomFormsRouter
* 0fba934 - Action custom_form_data_files/detail fixed

## [0.4.7] - 2022-06-10

* 3eea8f2 - CustomFormFields\PhoneField fixed
* 258ec01 - English names of custom for fields

## [0.4.6] - 2022-04-19

* d94aa1a - It is possible to send anotification on more email addresses
* 68bc49e - Up to five fields, the reset button is not displayed

## [0.4.5] - 2022-03-16

* b7c5ed9 - Form field fixed

## [0.4.4] - 2021-11-15

* 6e680f4 - Fix - better reaction on invalid parametr cfd_token

## [0.4.3] - 2021-11-15

* e40b5e5 - Added max limit of form submissions from one IP address
* b73f7de - The total number of submissions of individual forms is displayed in the administration
* a9aa57f - The first 3 values are displayed in the list of data records

## [0.4.2] - 2021-08-02

* Content type for XLSX export fixed

## [0.4.1] - 2021-08-02

* CSV header fixed - "#" was replaced with "id"

## [0.4] - 2021-08-02

* Refactoring - used package atk14/csv-writer

## [0.3] - 2021-07-31

* Added CustomFormFields\HcaptchaField

## [0.2] - 2021-01-26

* After a successful Custom Form submission, the CustomFormsController::$custom_form_data_just_created is set
* In administration, the code can be set on a Custom Form

## [0.1] - 2020-03-24

First tagged release
