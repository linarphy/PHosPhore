# Installation

PHosPhore needs all the necessary [requirements](#Requirements) to works proprely.

## Requirements

`?` indicate the use of these requirement have not been tested yet.

- Web server:
	- Apache http server >= 2.0
	- nginx >= ?
- PHP >= 8.0
- Database engine:
	- MYSQL >= 5.5
	- MariaDB >= 5.5
	- PostgreSQL >= ?

## Manual Installation

In addition to the [requirements](#Requirements), a manual installation requires [git](https://git-scm.com).

Clone the repository into a temporary place
```sh
git clone https://github.com/gugus2000/PHosPhore
```

### Virtual host

If several websites are to be hosted by the server, virtual hosts should be used.
The method varies depending on the web servers used, check on internet to setup the configuration.

The root folder of this website is [`src`](../../src) (be free to rename it).

### Single host

Move the content of [`src`](../../src) folder into your web directory folder.


From now on, this directory will be the `root folder`.

### HTTP configuration

Here is an Apache http server configuration for the framework over http (https is strongly recommended):
```
<VirtualHost *:80>
	ServerAdmin <server.admin.email.@go.there>
	DocumentRoot "<path to the root folder>"
	ServerName <URL of the website>
	<Directory "<path to the root folder>">
		Options -Indexes +FollowSymLinks +MultiViews
		AllowOverride All
		Require all granted
		<IfModule mod_rewrite.c>
			RewriteEngine On
			RewriteCond %{DOCUMENT_ROOT} !-f
			RewriteCond ^(.*)/asset/(.*)$ /asset/$2 [L,R=301]
			RewriteCond ^(!(.*)/asset/(.*)).*/(.*\.(png|ico|xml|gif|svg)) /$1
			RewriteCond ^\.(eot|woff2|woff|ttf|js|ico|gif|jpg|png|css|html|swf|flv|xml|txt|svg)$ index.php [QSA,L]
		</IfModule>
		<IfModule mod_headers.c>
			Header always set Permission-Policy: interest-cohort=()
		</IfModule>
	</Directory>
</VirtualHost>
```

PHosPhore is now installed, the framework [configuration](configuration.md) can now be started.
