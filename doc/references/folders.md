# Folders

PHosPhore use many different folder to separate each type of data.

## `root folder`

The root folder is the framework folder, where you installed PHosPhore.

Layout:

- [`/index.php`](#index.php)
- [`/asset`](#assets)
- [`/class`](#class)
- [`/config`](#config)
- [`/func`](#func)
- [`/hook`](#hook)
- [`/lang`](#lang)
- [`/locale`](#locale)
- [`/mod`](#mod)
- [`/page`](#page)

### index.php

Starting point of the framework.

### assets

Folder that contains all the static files, like `CSS`, `HTML` or `JS` files.

### class

Folder that contains all the PHP classes files. They are organized as the class namespace.

### config

Folder that contains all the PHP configuration files.

Layout:

- [`/config/config.php`](#configconfig.php)
- [`/config/class`](#configclass)
- [`/config/core`](#configcore)
- [`/config/mod`](#configmod)

#### /config/config.php

Define user configuration.

**It is the only file to modify to change the user configuration.**

#### /config/class

Folder that contains class configuration.

#### /config/core

Folder that contains configuration file for the framework core.

#### /config/mod

Folder that contains configuration file for modules.
