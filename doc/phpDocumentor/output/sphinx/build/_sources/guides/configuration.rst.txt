Configuration
=============

There is currently two way to configure PHosPhore.

- :ref:`Manual`
- :ref:`Using PHosPhore_installation module`

.. _Manual:

Manual
------

To manually install this framework, you need to setup the database. To do this, you'll need to read the documentation of the :ref:`database structure`.

Then you'll need to manually add default element into the database:

- error folder
- main folder
- home folder (which is inside the main folder)
- error route
- main route
- home route
- link between main (parent) and home (child)
- main page parameter:

  - key: preset
  - value: default_html

- guest user
- permission associated to home and error route

.. _`Using PHosPhore_installation module`:

PHosPhore_installation
----------------------

To use this method, you'll need git_.

.. highlight:: shell

Clone the module repository into a temporary place::

    git clone https://github.com/gugus2000/PHosPhore_installation

Once it's done, move the ``src`` folder into your PHosPhore :ref:`root folder`.

Modules
=======

Description
-----------

PHosPhore_installation is an example of what a PHosPhore module can do.

Modules come in the form of a folder whose content is to be copied into the :ref:`root folder`. For a better management of module deletion, update and installation, a module manager is under development.
A module must never modify a file which already exist for two reasons:

- compatibility between module
- a PHosPhore update will break the module

A module can therefore add pages, configuration files, language files, use hooks, and execute code when the module is first installed.

Folder structure
----------------

For a module named <module name>

- :ref:`/mod`:

  - `<module name>`

    - :ref:`README.md`
    - :ref:`mod.xml`
    - `install`:

      - :ref:`install.php`

.. _`README.md`:

README.md
~~~~~~~~~

Detailed module description in markdown

.. _`mod.xml`:

mod.xml
~~~~~~~

XML file which describe specific part of the module

- :ref:`name`
- :ref:`authors`

  - :ref:`author`

    - :ref:`author_name`
    - :ref:`author_contact`
    - :ref:`author_work`

- :ref:`description`
- :ref:`version`
- :ref:`structure`

.. _`name`:

name
````

Module name.

.. _`authors`:

authors
```````

List of :ref:`author`.

.. _`author`:

author
``````

Author metadata.

.. _`author_name`:

name
````

Name (nickname) of the author.

.. _`author_contact`:

contact
```````

Contact information of the author.

.. _`author_work`:

work
````

Information about the nature of the work made by the author.

.. _`description`:

description
```````````

Module description.

.. _`version`:

version
```````

Module version, in the format: int|(int.<this format>)

Use of semver_ recommanded, module manager will use it to update.

.. _`structure`:

structure
`````````


.. _`install.php`:

install.php
~~~~~~~~~~~

Script to run at first installation

.. _git: https://git-scm.com
.. _semver: https://semver.org
