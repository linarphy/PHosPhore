# Database

## Database structure

Tables:

- [`phosphore_configuration`](#phosphore_configuration)
- [`phosphore_content`](#phosphore_content)
- [`phosphore_folder`](#phosphore_folder)
- [`phosphore_link_notification_user`](#phosphore_link_notification_user)
- [`phosphore_link_page_page_parameter`](#phosphore_link_page_page_parameter)
- [`phosphore_link_role_user`](#phosphore_link_role_user)
- [`phosphore_link_route_route`](#phosphore_link_route_route)
- [`phosphore_link_route_route_parameter`](#phosphore_link_route_route_parameter)
- [`phosphore_login_token`](#phosphore_login_token)
- [`phosphore_notification`](#phosphore_notification)
- [`phosphore_page_parameter`](#phosphore_page_parameter)
- [`phosphore_permission`](#phosphore_permission)
- [`phosphore_route`](#phosphore_route)
- [`phosphore_route_parameter`](#phosphore_route_parameter)
- [`phosphore_user`](#phosphore_user)

### phosphore_configuration

Table which store user configuration.

Content:

- id int not null auto increment
- id_user int not null
- name varchar not null
- value varchar not null

primary (id)

foreign key:

- id_user => id for [`phosphore_user`](#phosphore_user), on update cascade, on delete cascade

### phosphore_content

Table which store dynamic content

Content:

- id_content int not null
- lang varchar not null
- text varchar
- date_creation datetime default now

primary (id_content, lang)

### phosphore_folder

Table which store route folder

Content:

- id int not null auto increment
- name varchar not null
- id_parent int default -1

primary (id)

### phosphore_link_notification_user

Table which store links between notification and user

Content:

- id_notification int not null
- id_user int not null

primary (id_notification, id_user)

foreign key:

- id_notification => id for :ref:`phosphore_notification`, on update cascade, on delete restrict
- id_user => id for :ref:`phosphore_user`, on update cascade, on delete restrict

### phosphore_link_page_page_parameter

Table which store links between page to page parameter

Content:

- id_page int not null
- id_parameter int not null

primary (id_page, id_parameter)

foreign key:

- id_page => id for :ref:`phosphore_route`, on update cascade, on delete restrict
- id_parameter => id for :ref:`phosphore_page_parameter`, on update cascade, on delete restrict


### phosphore_link_role_user

Table which store link between role to user

Content:

- name_role varchar not null
- id_user int not null

primary (name_role, id_user)

foreign key:

- id_user => id for :ref:`phosphore_user`, on update cascade, on delete cascade

### phosphore_link_route_route

Table which store link between routes

Content:

- id_route_parent int not null
- id_route_child int not null

primary (id_route_parent, id_route_child)

foreign key:

- id_route_parent => id for :ref:`phosphore_route`, on update cascade, on delete restrict
- id_route_child => id for :ref:`phosphore_route`, on update cascade, on delete restrict

### phosphore_link_route_route_parameter

Table which store link between route to route parameter

Content:

- id_parameter int not null
- id_route int not null

primary (id_parameter, id_route)

foreign key:

- id_parameter => id for :ref:`phosphore_route_parameter`, on update cascade, on delete restrict
- id_route => id for :ref:`phosphore_route`, on update cascade, on delete restrict

### phosphore_login_token

Table which store temporary login token

Content:

- date_expiration datetime not null
- id int not null
- selector varchar not null
- validator_hashed varchar not null

primary (selecto)

foreign key:

- id => id for :ref:`phosphore_user`, on update cascade, on delete cascade

### phosphore_notification

Table which store notifications

Content:

- id int not null auto increment
- id_content int not null
- date datetime default now
- type varchar not null

primary (id)

foreign key:

- id_content => id_content for :ref:`phosphore_content`, on update cascade, on delete cascade

### phosphore_page_parameter

Table which store page parameter

Content:

- id int not null auto increment
- key varchar not null
- value varchar not null

primary (id)

### phosphore_permission

Table which store permissions

Content:

- id int not null auto increment
- id_route int not null
- name_role varchar not null

primary (id)

foreign key:

- id_route => id for :ref:`phosphore_route`, on update cascade, on delete cascade

### phosphore_route

Table which store route

Content:

- id int not null auto increment
- name varchar not null
- type bool

primary (id)

### phosphore_route_parameter

Table which store route parameter

Content:

- id int not null auto increment
- name varchar not null
- regex varchar
- necessary bool

primary (id)

### phosphore_user

Table which store user

Content:

- id int not nul auto increment
- date_registration datetime default now
- date_login datetime default now
- nickname varchar not null
- password_hashed varchar default null

primary (id)

## Database engine

Currently, only one database engine is officially supported:

- MYSQL/MariaDB

However, if one check in [`\core\DBFactory`](../../src/class/core/DBFactory.class.php)
`DRIVERS` constant, one can see that PostgreSQL, Firebird and sqlite appears.
No test was done for these engines, and automatic installation does not work for them.
