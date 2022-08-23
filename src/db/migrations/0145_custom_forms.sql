CREATE SEQUENCE seq_custom_forms;
CREATE TABLE custom_forms (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_forms'),
	--
	code VARCHAR(255), -- alternative key
	--
	notify_to_email VARCHAR(255),
	--
	visible BOOLEAN DEFAULT TRUE NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_customforms_code UNIQUE (code),
	CONSTRAINT fk_customforms_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customforms_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_custom_form_fieldsets;
CREATE TABLE custom_form_fieldsets (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_form_fieldsets'),
	--
	custom_form_id INT NOT NULL,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_customformfieldsets_customforms FOREIGN KEY (custom_form_id) REFERENCES custom_forms ON DELETE CASCADE,
	CONSTRAINT fk_customformfieldsets_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customformfieldsets_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_custom_form_fields;
CREATE TABLE custom_form_fields (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_form_fields'),
	--
	custom_form_id INT NOT NULL,
	custom_form_fieldset_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,
	class_name VARCHAR(255) NOT NULL,
	required BOOLEAN NOT NULL DEFAULT TRUE,
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_customformfields UNIQUE (custom_form_id,name),
	CONSTRAINT fk_customformfields_customforms FOREIGN KEY (custom_form_id) REFERENCES custom_forms ON DELETE CASCADE,
	CONSTRAINT fk_customformfields_customformfieldsets FOREIGN KEY (custom_form_fieldset_id) REFERENCES custom_form_fieldsets ON DELETE CASCADE,
	CONSTRAINT fk_customformfields_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customformfields_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_custom_form_field_choices;
CREATE TABLE custom_form_field_choices (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_form_field_choices'),
	--
	custom_form_field_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_customformfieldchoices UNIQUE (custom_form_field_id,name),
	CONSTRAINT fk_customformfieldchoices_customformfields FOREIGN KEY (custom_form_field_id) REFERENCES custom_form_fields ON DELETE CASCADE,
	CONSTRAINT fk_customformfieldchoices_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_customformfieldchoices_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);


CREATE SEQUENCE seq_custom_form_data;
CREATE TABLE custom_form_data (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_form_data'),
	--
	custom_form_id INT NOT NULL,
	url VARCHAR(255), -- TODO: This should be longer, like 2048 chars or more.
	page_title VARCHAR(255),
	--
	data JSON,
	--
	created_by_user_id INT,
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	created_from_user_agent VARCHAR,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	--
	CONSTRAINT fk_customformdata_customforms FOREIGN KEY (custom_form_id) REFERENCES custom_forms ON DELETE CASCADE,
	CONSTRAINT fk_customformdata_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users
);
CREATE INDEX in_customformdata_customformid ON custom_form_data(custom_form_id);

-- table for storing uploaded files
CREATE SEQUENCE seq_custom_form_data_files;
CREATE TABLE custom_form_data_files (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_custom_form_data_files'),
	--
	custom_form_data_id INT, -- it might be null during the moment before custom_form_data record is created
	name VARCHAR(255) NOT NULL, -- name from the form, e.g. document, file, image...
	--
	filename VARCHAR(255) NOT NULL,
	filesize INT NOT NULL,
	mime_type VARCHAR(255) NOT NULL,
	body TEXT, -- base64 encoded
	--
	CONSTRAINT unq_customformdatafiles UNIQUE (custom_form_data_id,name),
	CONSTRAINT fk_customformdatafiles_customformdata FOREIGN KEY (custom_form_data_id) REFERENCES custom_form_data ON DELETE CASCADE
);
