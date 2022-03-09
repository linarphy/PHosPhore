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
