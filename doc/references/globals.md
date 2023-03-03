# GLOBALS variables

The framework use and store some variable in the `$GLOBALS` array.

To get a variable named `<var>` stored in `$GLOBALS`, one needs to use

```php
$GLOBALS['<var>']
```

- [`cache`](#cache)
- [`config`](#config)
- [`Hook`](#hook)
- [`lang`](#lang)
- [`locale`](#locale)
- [`Logger`](#logger)
- [`Router`](#router)
- [`Visitor`](#visitor)

## cache

Array used to store redundant data.

### Examples

```php
echo 'These templates are already loaded ' . $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'];
```

### Structure

- [`cache > class`](#cache--class)
- [`cache > core`](#cache--core)
- [`cache > mod`](#cache--mod)
- [`cache > page`](#cache--page)

#### cache > class

Store data used by classes.

#### cache > core

Store data used internaly by the framework.

#### cache > mod

Store data used by module.

#### cache > page

Store data used in page.

## config

Array used to store configuration data.

### Example

```php
echo 'Database driver you use: ' . $GLOBALS['config']['core']['lang']['server'];
```

### Structure

- [`config > class`](#config--class)
- [`config > core`](#config--core)
- [`config > mod`](#config--mod)
- [`config > page`](#config--page)

#### config > class

Store configuration data used by classes.

#### config > core

Store configuration data used internaly by the framework.

#### config > mod

Store configuration data used by modules.

#### config > page

Store configuration data used by page.

## Hook

`Hook` is the [`\core\Hook`](../../src/class/core/Hook.class.php) used to dispatch
hooks for this session.

### Examples

```php
// load hooks in mod/<mod>/main/ which can access the argument $argument
$GLOBALS['Hook']->load(['mod', '<mod>', 'main'], [$argument])
```

## lang

Array used to store string or other data linked to the server language, as log message.

### Examples

```php
echo 'The server language is ' . $GLOBALS['lang']['core']['lang']['abbr'];
```

### Structure

- [`lang > class`](#lang--class)
- [`lang > core`](#lang--core)
- [`lang > mod`](#lang--mod)
- [`lang > page`](#lang--page)

#### lang > class

Store language data used by classes.

#### lang > core

Store language data used internaly by the framework.

#### lang > mod

Store language data used by modules.

#### lang > page

Store language data used by pages.

## locale

Array used to store string or other data linked to the user language.

### Examples

```php
echo 'The user language is ' . $GLOBALS['locale']['core']['locale']['abbr'];
```

### Structure

- [`locale > class`](#locale--class)
- [`locale > core`](#locale--core)
- [`locale > mod`](#locale--mod)
- [`locale > page`](#locale--page)

#### lang > class

Store user language data used by classes.

#### lang > core

Store user language data used internaly by the framework.

#### lang > mod

Store user language data used by modules.

#### lang > page

Store user language data used by pages.

## Logger

`Logger` is the [`\core\Logger`](../../src/class/core/Logger.class.php) used to generate logs for this session.

### Examples

```php
// generate a log line of type info and <my type>
$GLOBALS['Logger']->log(\log\Logger::TYPES['info'], '<my type>'], 'a log line');
```

## Router

`Router` is the [`\core\Router`](../../src/class/core/Router.class.php) used to generate/manage
route for this session.

### Examples

```php
// decode an internal url
$route = $GLOBALS['Router']->decodeRoute('main/home');
```

## Visitor

`Visitor` is the [`\user\Visitor`](../../src/class/user/Visitor.class.php) who will access
the page.

### Examples

```php
// store the page_element of the page in a variable
$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');
```

**`$GLOBALS['visitor']` can be uninitialized, unauthentificated or malformed**
