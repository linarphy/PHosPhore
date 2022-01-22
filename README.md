# PHosPhore
 
 A PHP framework

## DISCLAIMER

Phosphore has been rebuilt and is now WIP (again), instructions here may be out of date for now.

## Getting started

This framework is based on a special project architecture. It is a set of files that you have to complete and modify according to your preferences and needs.

### Prerequisites

* PHP >= 7.2 (no verification performed below this version)
* MYSQL > 5.5 or MariaDB > 5.5 (no verification performed below this version)

### Installation

To use this framework, you have to copy the [src](https://github.com/gugus2000/PHosPhore/tree/dev/src) folder content into your web directory. One it's done, import the "example.sql" into a database in your Mysql server.

#### Local

Notice: if you are on local and you want to use it in a directory inside the "htdocs" or "www" directory, you have to use Virtual Host to make the default router mode works. The manipulations are explained below. However, you can just change the router mode by adding at the end of ``config/config.php`` :
```php
/* [ROUTER] */
/* Default Router mode */
$GLOBALS['config']['route_mode']=1;
```

##### Windows

See [here](https://stackoverflow.com/questions/2658173/setup-apache-virtualhost-windows).

##### Linux

See [here](https://thelinuxos.com/how-to-setup-apache-virtual-hosts-on-ubuntu-18-04-and-16-04/).

##### Mac
See [here](https://jasonmccreary.me/articles/configure-apache-virtualhost-mac-os-x/).

## How to use

The doc is available [here](https://www.phosphore.org).
You can use examples website (in the examples folder) to help you to understand how this framework works.

## Authors

* **gugus2000** - *initial work*

## Versioning

We use [SemVer](http://semver.org/) for versioning.

## License

This project is licensed under the Chocolate-Ware License - see the [LICENSE](LICENSE) file for details
