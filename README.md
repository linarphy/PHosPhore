
# PHosPhore
 
 A simple PHP framework

## Getting started

This framework is based on a special project architecture. It is nothing more than a set of files that you just have to complete and modify according to your preferences and needs.

### Prerequisites

* PHP >= 5.3
* MYSQL > 5.5 or MariaDB > 5.5

You can install XAMPP [here](https://www.apachefriends.org/fr/index.html) to use it on a local web server

### Installation

To use this framework, you just have to copy the "main" folder content into your root directory. One it's done, import the "example.sql" into your Mysql server.

#### Local

Notice if you are on local and you want to use it in a directory inside the "htdocs" or "www" directory, you have to use Virtual Host to make the default router mode works:

##### Windows

On windows

* create the virtual host for your server by adding at the ens of apache/conf/extra/httpd-vhosts.conf located in your server directory
	```
	<VirtualHost <url for accessing to this website>:<port>>
	    DocumentRoot "<absolute path to your folder>"
	    ServerName <url for accessing to this website>
	</VirtualHost>
	```
	where:
	* ```<url for accessing to this website>``` is the url you have to write in your browser to reach your website of this framework
	* ```<port>``` is the port where apache will listen, it's 80 by default
	* ```<absolute path to your folder>``` is the path to the folder where files of the framework are

	For example on Windows with a default installation of XAMPP, if I copy the directory "main" and I put it into the htdocs directory, adding at the end of C:/xampp/apache/conf/extra/httpd-vhosts.conf :
	```
	<VirtualHost main.localhost:80>
	    DocumentRoot "C:/xampp/htdocs/main"
	    ServerName main.localhost
	</VirtualHost>
	```
	will allow me to access to this directory by typing main.localhost in a browser's address bar
* Add
	```
	127.0.0.1      <url for accessing to this website>
	```
	at the end of C:/Windows/System32/drivers/etc/hosts (with a text editor with admin right)

You can see [here](https://stackoverflow.com/questions/2658173/setup-apache-virtualhost-windows) if you don't understand

##### Linux

see [here](https://thelinuxos.com/how-to-setup-apache-virtual-hosts-on-ubuntu-18-04-and-16-04/)

## How to use

You will see examples in the "examples" directory soon
The doc will be created soon

## Authors

* **gugus2000** - *initial work*

## Versioning

We use [SemVer](http://semver.org/) for versioning.

## License

This project is licensed under the Beerware License - see the [LICENSE](LICENSE) file for details
