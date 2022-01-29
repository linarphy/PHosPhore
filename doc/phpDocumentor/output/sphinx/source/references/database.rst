========
Database
========

.. _`database structure`:

------------------
Database structure
------------------

- :ref:`phosphore_configuration`
- :ref:`phosphore_content`
- :ref:`phosphore_folder`
- :ref:`phosphore_link_notification_user`
- :ref:`phosphore_link_page_page_parameter`
- :ref:`phosphore_link_role_user`
- :ref:`phosphore_link_route_route`
- :ref:`phosphore_link_route_route_parameter`
- :ref:`phosphore_login_token`
- :ref:`phosphore_notification`
- :ref:`phosphore_page_parameter`
- :ref:`phosphore_permission`
- :ref:`phosphore_route`
- :ref:`phosphore_route_parameter`
- :ref:`phosphore_user`

.. _`phosphore_configuration`:

phosphore_configuration
-----------------------

Description
~~~~~~~~~~~

Table which store user configuration

Layout
~~~~~~

- id int not null auto increment
- id_user int not null
- name varchar not null
- value varchar not null

primary (id)

foreign key:

- id_user => id for :ref:`phosphore_user`, on update cascade, on delete cascade

.. _`phosphore_content`:

phosphore_content
-----------------

Description
~~~~~~~~~~~

Table which store dynamic content

Layout
~~~~~~

- id_content int not null
- lang varchar not null
- text varchar
- date_creation datetime default now

primary (id_content, lang)

.. _`phosphore_folder`:

phosphore_folder
----------------

Description
~~~~~~~~~~~

Table which store route folder

Layout
~~~~~~

- id int not null auto increment
- name varchar not null
- id_parent int default -1

primary (id)

.. _`phosphore_link_notification_user`:

phosphore_link_notification_user
--------------------------------

Description
~~~~~~~~~~~

Table which store links between notification and user

Layout
~~~~~~

- id_notification int not null
- id_user int not null

primary (id_notification, id_user)

foreign key:

- id_notification => id for :ref:`phosphore_notification`, on update cascade, on delete restrict
- id_user => id for :ref:`phosphore_user`, on update cascade, on delete restrict

.. _`phosphore_link_page_page_parameter`:

phosphore_link_page_page_parameter
----------------------------------

Description
~~~~~~~~~~~

Table which store links between page to page parameter

Layout
~~~~~~

- id_page int not null
- id_parameter int not null

primary (id_page, id_parameter)

foreign key:

- id_page => id for :ref:`phosphore_route`, on update cascade, on delete restrict
- id_parameter => id for :ref:`phosphore_page_parameter`, on update cascade, on delete restrict

.. _`phosphore_link_role_user`:

phosphore_link_role_user
------------------------

Description
~~~~~~~~~~~

Table which store link between role to user

Layout
~~~~~~

- name_role varchar not null
- id_user int not null

primary (name_role, id_user)

foreign key:

- id_user => id for :ref:`phosphore_user`, on update cascade, on delete cascade

.. _`phosphore_link_route_route`:

phosphore_link_route_route
--------------------------

Description
~~~~~~~~~~~

Table which store link between routes

Layout
~~~~~~

- id_route_parent int not null
- id_route_child int not null

primary (id_route_parent, id_route_child)

foreign key:

- id_route_parent => id for :ref:`phosphore_route`, on update cascade, on delete restrict
- id_route_child => id for :ref:`phosphore_route`, on update cascade, on delete restrict

.. _`phosphore_link_route_route_parameter`:

phosphore_link_route_route_parameter
------------------------------------

Description
~~~~~~~~~~~

Table which store link between route to route parameter

Layout
~~~~~~

- id_parameter int not null
- id_route int not null

primary (id_parameter, id_route)

foreign key:

- id_parameter => id for :ref:`phosphore_route_parameter`, on update cascade, on delete restrict
- id_route => id for :ref:`phosphore_route`, on update cascade, on delete restrict

.. _`phosphore_login_token`:

phosphore_login_token
---------------------

Description
~~~~~~~~~~~

Table which store temporary login token

Layout
~~~~~~

- date_expiration datetime not null
- id int not null
- selector varchar not null
- validator_hashed varchar not null

primary (selecto)

foreign key:

- id => id for :ref:`phosphore_user`, on update cascade, on delete cascade

.. _`phosphore_notification`:

phosphore_notification
----------------------

Description
~~~~~~~~~~~

Table which store notifications

Layout
~~~~~~

- id int not null auto increment
- id_content int not null
- date datetime default now
- type varchar not null

primary (id)

foreign key:

- id_content => id_content for :ref:`phosphore_content`, on update cascade, on delete cascade

.. _`phosphore_page_parameter`:

phosphore_page_parameter
------------------------

Description
~~~~~~~~~~~

Table which store page parameter

Layout
~~~~~~

- id int not null auto increment
- key varchar not null
- value varchar not null

primary (id)

.. _`phosphore_permission`:

phosphore_permission
--------------------

Description
~~~~~~~~~~~

Table which store permissions

Layout
~~~~~~

- id int not null auto increment
- id_route int not null
- name_role varchar not null

primary (id)

foreign key:

- id_route => id for :ref:`phosphore_route`, on update cascade, on delete cascade

.. _`phosphore_route`:

phosphore_route
---------------

Description
~~~~~~~~~~~

Table which store route

Layout
~~~~~~

- id int not null auto increment
- name varchar not null
- type bool

primary (id)

.. _`phosphore_route_parameter`:

phosphore_route_parameter
-------------------------

Description
~~~~~~~~~~~

Table which store route parameter

Layout
~~~~~~

- id int not null auto increment
- name varchar not null
- regex varchar
- necessary bool

primary (id)

.. _`phosphore_user`:

phosphore_user
--------------

Description
~~~~~~~~~~~

Table which store user

Layout
~~~~~~

- id int not nul auto increment
- date_registration datetime default now
- date_login datetime default now
- nickname varchar not null
- password_hashed varchar default null

primary (id)

---------------
Database engine
---------------

Currently, two database engine are officially supported:

- MYSQL/MariaDB
- PostgreSQL

However, if one check in \core\DBFactory DRIVERS constant, one can see that Firebird and sqlite appears.
No test was done for these engines, and automatic installation does not work for them.
