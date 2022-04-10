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

Where `<server.admin.email.@go.there>` is the email of this server admin and `<path to the root folder>` is the path to the `root_folder`.

### File & Folder permissions

The `root_folder` should have `read`, `execute` and `write` permission for the webserver user.
Every folder in the `root_folder` should have `read` and `execute` permission for the webserver user.
Every files in the `root_folder` should have `read` permission for the webserver user.

`mod` should have `read`, `execute` and `write` permission for the webserver user.

An example for a traditional linux hosted server:
```sh
sudo chown -R <username>:<webserver group> <path/to/root_folder>
sudo chmod -R 750 <path/to/root_folder>
sudo chmod 770 <path/to/root_folder>
sudo chmod -R 770 <path/to/root_folder>/mod
```

Where `<username>` is the username of the server admin, `<webserver group>` is the name of the group associated to the webserver (for apache, it can be httpd or www-data for example).
`<path/to/root_folder>` is the path to the `root_folder`.

PHosPhore is now installed, the framework [configuration](configuration.md) can now be started.
