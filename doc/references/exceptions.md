# Exceptions

PHosPhore use differents exception to separate each error type.

## Exceptions list

- [`Exception`](#Exception)
- [`Exception > class`](#Exception--class)
- [`Exception > core`](#Exception--core)
- [`Exception > mod`](#Exception--mod)
- [`Exception > page`](#Exception--page)

### Exception > class

Exceptions used by classes.

### Exception > core

Exceptions used internaly by the framework.

### Exception > mod

Exceptions used by module.

### Exception > page

Exceptions used in page.

## Resume

PHosPhore exception are classes that inherit from [`\Exception`](https://www.php.net/manual/fr/class.exception.php).
They are used to improve accuracy of exception catching in some part of the codebase.
