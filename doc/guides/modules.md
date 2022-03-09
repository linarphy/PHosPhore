# Modules

## Description

PHosPhore can works with module to ease the use of PHosPhore. They are sets of files put in
the `root directory`.

The [`PHosPhore_installation`](https://github.com/gugus2000/PHosPhore_installation) module is
an example of these.

## Capabilities

A module can:

- add webpage
- add API
- change the behavior of some functions
- add assets
- add translation
- add configuration files
- add other modules

## Security

Due of their abilities, modules should not be used lightly, as they can provoke bug, unwanted
changes or security vulnerabilies.

## Module creation

Module should use a folder structure convention.

### Folder structure

For a module named `<module name>`:

- `root folder`:
	- `mod`:
		- `mod/<module name>`:
			- [`mod/<module name>/README.md`](#README.MD)
			- [`mod/<module name>/mod.xml`](#mod.xml)
			- *\**`mod/<module name>/install`:
				- *\**[`mod/<module name>/install/install.php`](#install.php)

File or folder annoted with *\** are optional, other are **mandatory**.

### README.MD

Detailed module description in markdown.

### mod.xml

XML file which describe specific part of the module, an XML Schema is available [here](../module/mod.xsd).

### install.php

PHP script to run at first installation.
