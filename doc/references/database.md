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

### phosphore_folder

### phosphore_link_notification_user

### phosphore_link_page_page_parameter

### phosphore_link_role_user

### phosphore_link_route_route

### phosphore_link_route_route_parameter

### phosphore_login_token

### phosphore_notification

### phosphore_page_parameter

### phosphore_permission

### phosphore_route

### phosphore_route_parameter

### phosphore_user

## Database engine

Currently, two database engine are officially supported:

- MYSQL/MariaDB

However, if one check in [`\core\DBFactory`](../../src/class/core/DBFactory.class.php)
`DRIVERS` constant, one can see that PostgreSQL, Firebird and sqlite appears.
No test was done for these engines, and automatic installation does not work for them.
