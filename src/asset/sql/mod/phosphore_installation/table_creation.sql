CREATE TABLE phosphore_content (
    id_content INT NOT NULL,
    lang VARCHAR(255) NOT NULL,
    text TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_content, lang)
);
CREATE TABLE phosphore_route (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type BOOLEAN,
    PRIMARY KEY (id)
);
CREATE TABLE phosphore_folder (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	id_parent INT DEFAULT -1,
	PRIMARY KEY (id)
);
CREATE TABLE phosphore_route_parameter (
    id  INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    regex VARCHAR(255),
    necessary BOOLEAN,
    PRIMARY KEY (id)
);
CREATE TABLE phosphore_link_route_route_parameter (
    id_parameter  INT NOT NULL,
    id_route INT NOT NULL,
    PRIMARY KEY (id_parameter, id_route),
    FOREIGN KEY (id_parameter)
    	REFERENCES phosphore_route_parameter (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_route)
    	REFERENCES phosphore_route (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE phosphore_link_route_route (
    id_route_parent  INT NOT NULL,
    id_route_child INT NOT NULL,
    PRIMARY KEY (id_route_parent, id_route_child),
    FOREIGN KEY (id_route_parent)
    	REFERENCES phosphore_route (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_route_child)
    	REFERENCES phosphore_route (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE phosphore_user (
    id  INT NOT NULL AUTO_INCREMENT,
    date_registration DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_login DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nickname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE phosphore_configuration (
    id  INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    value VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user)
    	REFERENCES phosphore_user (id)
    	ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE phosphore_notification (
    id  INT NOT NULL AUTO_INCREMENT,
    id_content INT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_content)
    	REFERENCES phosphore_content (id_content)
    	ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE phosphore_page_parameter (
    id  INT NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE phosphore_link_notification_user (
    id_notification INT NOT NULL,
    id_user INT NOT NULL,
    PRIMARY KEY (id_notification, id_user),
    FOREIGN KEY (id_notification)
    	REFERENCES phosphore_notification (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_user)
    	REFERENCES phosphore_user (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE phosphore_link_page_page_parameter (
    id_page INT NOT NULL,
    id_parameter INT NOT NULL,
    PRIMARY KEY (id_page, id_parameter),
    FOREIGN KEY (id_page)
    	REFERENCES phosphore_route (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_parameter)
    	REFERENCES phosphore_page_parameter (id)
    	ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE phosphore_permission (
    id INT NOT NULL AUTO_INCREMENT,
    id_route INT NOT NULL,
    name_role VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_route)
    	REFERENCES phosphore_route (id)
    	ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE phosphore_link_role_user (
    name_role VARCHAR(255) NOT NULL,
    id_user INT NOT NULL,
    PRIMARY KEY (name_role, id_user),
    FOREIGN KEY (id_user)
    	REFERENCES phosphore_user (id)
    	ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE phosphore_login_token (
	date_expiration DATETIME NOT NULL,
	id_user INT NOT NULL,
	selector VARCHAR(255) NOT NULL,
	validator_hashed VARCHAR(255) NOT NULL,
	PRIMARY KEY (selector),
	FOREIGN KEY (id_user)
		REFERENCES phosphore_user (id)
		ON UPDATE CASCADE ON DELETE CASCADE
);
