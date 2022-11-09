# Process

## index.php

[`index.php`](../../src/index.php) is the starting point of the framework.


## Steps

1. Start the session
2. Set default timezone
3. Set a custom error handler
4. Set a custom shutdown function
5. Include `func/core/init.php`
6. Create the hook manager
7. Create the log manager
8. Create the router
9. Create the visitor (check token)
10. Retrieve the visitor information stored in the database
11. Connect the visitor
12. Load the page set with the router
