# Configuration

## First configuration

There is currently two way to configure PHosPHore.

- [Manual](#Manual)
- [Using PHosPhore_installation module](#Automatic-configuration)

### Automatic configuration

It's the easiest method, which needs [git](https://git-scm.com).

Clone the module repository into a temporary place
```shell
git clone https://github.com/gugus2000/PHosPhore_installation
```

Once it's done, move the `src` folder into your PHosPhore `root folder`, and load the website (for the first time).

### Manual

To manually install this framework, you need to setup the database. To do this, you'll need to read the documentation of the :ref:`database structure`.

Then you'll need to manually add default element into the database:

- error folder
- main folder
- home folder (which is inside the main folder)
- root route (id = 0)
- error route
- main route
- home route
- link between root (parent) and main (child)
- link between root (parent) and error (child)
- link between main (parent) and home (child)
- root page parameter:

  - key: preset
  - value: default_html

  - key: default_page
  - value: `<id of main route>`

- main page parameter:

	- key: default_page
	- value: `<id of home route>`

- guest user
- permission associated to home and error route



