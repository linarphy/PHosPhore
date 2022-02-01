=======
Process
=======

index.php
=========

:ref:`/index.php` is the starting point of the framework.

- Start the session
- Set default timezone
- Set a custom error handler
- Set a custom shutdown function
- Include :ref:`/func/core/init.php`
- Create the hook manager
- Create the log manager
- Create the router
- Create the visitor (check token)
- Retrieve the visitor information stored in the database
- Connect the visitor
- Load the page set with the router
