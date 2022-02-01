=======
Folders
=======

PHosPhore use many different folder to separate each type of data:

.. _`root folder`:

-----------
root folder
-----------

~~~~~~~~~~~
Description
~~~~~~~~~~~

The root folder is the framework folder, where you installed PHosPHore.

~~~~~~
Layout
~~~~~~

- :ref:`/index.php`
- :ref:`/assets`
- :ref:`/class`
- :ref:`/config`
- :ref:`/func`
- :ref:`/hook`
- :ref:`/lang`
- :ref:`/locale`
- :ref:`/mod`
- :ref:`/page`

.. _/index.php:

----------
/index.php
----------

~~~~~~~~~~~
Description
~~~~~~~~~~~

``index.php`` is the starting point of the framework.

.. _/assets:

-------
/assets
-------

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``assets`` folder contains all the static files, like ``CSS``, ``HTML`` or ``Javascript`` files.

.. _/class:

------
/class
------

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``class`` folder contains all the PHP classes files. They are organized as the class namespace.

.. _/config:

-------
/config
-------

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``config`` folder contains all the PHP configuration files.

~~~~~~
Layout
~~~~~~

- :ref:`/config/config.php`
- :ref:`/config/class`
- :ref:`/config/core`
- :ref:`/config/mod`

.. _`/config/config.php`:

/config/config.php
------------------

Description
~~~~~~~~~~~

Define user configuration.

.. _`/config/class`:

/config/class
-------------

Description
~~~~~~~~~~~

Contains class configuration.

.. _`/config/core`:

/config/core
------------

Description
~~~~~~~~~~~

Contains configuration file for the framework core.

.. _`/config/mod`:

/config/mod
-----------

Description
~~~~~~~~~~~

Contains configuration files for module, stored in different subfolder.

.. _/func:

-----
/func
-----

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``func`` folder contains all the PHP functions files.

~~~~~~
Layout
~~~~~~

- :ref:`/func/core/init.php`
- :ref:`/func/core/utils.php`

.. _`/func/core/init.php`:

/func/core/init.php
-------------------

Description
~~~~~~~~~~~

Define functions used at framework initialization.

.. _`/func/core/utils.php`:

/func/core/utils.php
--------------------

Description
~~~~~~~~~~~

Define functions used by the framework.

.. _/hook:

-----
\hook
-----

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``hook`` folder contains all the PHP hook files.

.. _/lang:

-----
/lang
-----

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``lang`` folder contains all the server lang files.

~~~~~~
Layout
~~~~~~

- :ref:`/lang/class`
- :ref:`/lang/core`
- :ref:`/lang/mod`
- :ref:`/lang/page`

.. _`/lang/class`:

/lang/class
-----------

Description
~~~~~~~~~~~

This folder contains server language files used in the class definition.

.. _`/lang/core`:

/lang/core
----------

Description
~~~~~~~~~~~

This folder contains server language files used in the framework core.

.. _`/lang/mod`:

/lang/mod
---------

Description
~~~~~~~~~~~

This folder contains server language files used in PHosPhore modules, stored in different subfolder.

.. _`/lang/page`:

/lang/page
----------

Description
~~~~~~~~~~~

This folder contains server language files used in webpage.

.. _/locale:

-------
/locale
-------

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``locale`` folder contains all the user lang files.

~~~~~~
Layout
~~~~~~

- :ref:`/locale/class`
- :ref:`/locale/core`
- :ref:`/locale/mod`
- :ref:`/locale/page`

.. _`/locale/class`:

/locale/class
-------------

Definition
~~~~~~~~~~

This folder contains user language file used in classes.

.. _`/locale/core`:

/locale/core
------------

Definition
~~~~~~~~~~

This folder contains user language file used in the framework core.

.. _`/locale/mod`:

/locale/mod
-----------

Definition
~~~~~~~~~~

This folder contains user language file used in PHosPhore modules, stored in different subfolder.

.. _`/locale/page`:

/locale/page
------------

Definition
~~~~~~~~~~

This folder contains user language file used in webpage.

.. _/mod:

----
/mod
----

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``mod`` folder contains all the module files.

~~~~~~
Layout
~~~~~~

- :ref:`/mod/installed`

.. _`/mod/installed`:

/mod/installed
--------------

Description
~~~~~~~~~~~

List of installed module

.. _/page:

-----
/page
-----

~~~~~~~~~~~
Description
~~~~~~~~~~~

The ``page`` folder contains all page definition files.
