# Folders

PHosPhore use many different folder to separate each type of data.

## `root folder`

The root folder is the framework folder, where you installed PHosPhore.

Layout:

- [`/index.php`](#indexphp)
- [`/asset`](#assets)
- [`/class`](#class)
- [`/config`](#config)
- [`/func`](#func)
- [`/hook`](#hook)
- [`/lang`](#lang)
- [`/locale`](#locale)
- [`/mod`](#mod)
- [`/page`](#page)

### /index.php

Starting point of the framework.

### /assets

Folder that contains all the static files, like `CSS`, `HTML` or `JS` files.

### /class

Folder that contains all the PHP classes files. They are organized as the class namespace.

### /config

Folder that contains all the PHP configuration files.

Layout:

- [`/config/config.php`](#configconfigphp)
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

Folder that contains configuration file for modules, stored in different subfolder.

### /func

Folder that contains all the PHP functions files.

Layout:

- [`/func/core/init.php`](#funccoreinitphp)
- [`/func/core/utils.php`](#funccoreutilsphp)

#### /func/core/init.php

Define functions used at framework initialization.

#### /func/core/utils.php

Define functions used by the framework.

### /hook

Folder that contains all the PHP hook files.

### /lang

Folder that contains all the server language files.

Layout:

- [`/lang/class`](#langclass)
- [`/lang/core`](#langcore)
- [`/lang/mod`](#langmod)
- [`/lang/page`](#langpage)

#### /lang/class

Folder that contains all server language files used in the class definition.

#### /lang/core

Folder that contains all server language files used in the framework core.

#### /lang/mod

Folder that contains all server language files used in PHosPhore modules, stored in different subfolders.

#### /lang/page

Folder that contains all server language files used in webpage.

### /locale

Folder that contains all the user language files.

Layout:

- [`/locale/class`](#localeclass)
- [`/locale/core`](#localecore)
- [`/locale/mod`](#localemod)
- [`/locale/page`](#localepage)

#### /locale/class

Folder that contains all the user language files used in classes.

#### /locale/core

Folder that contains all the user language files used in the framework core.

#### /locale/mod

Folder that contains all the user language files used in PHosPHore modules, stored in different subfolders.

#### /locale/page

Folder that contains all the user language files used in webpage.

### /mod

Folder that contains informations on installed modules.

Layout:

- [`/mod/installed`](#modinstalled)

#### /mod/installed

File that contains a list of installed module.

### /page

Folder that contains all page definition files.
