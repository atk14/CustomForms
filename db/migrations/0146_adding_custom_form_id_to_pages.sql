ALTER TABLE pages ADD custom_form_id INT;
ALTER TABLE pages ADD CONSTRAINT fk_pages_customformid FOREIGN KEY (custom_form_id) REFERENCES custom_forms(id);
