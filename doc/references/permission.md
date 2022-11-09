# Permission system

Each user can have multiple `roles`, and each role is a set of `permissions`.

A permission link a role to a `route` (a page or set of page), and give the user the capacity
to access the route.

## Note:

- An user can have roles that have the same permission.
- A role cannot `has` another role (for now).
- The error page has to be in the user permission for the user to see it
