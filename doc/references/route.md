# Routing system

PHosPhore has a routing system, that manage URL and link between them and page.

## Routes

A route is a page or a set of page.

A route can be seen as a node or a leaf in a tree.

### Example

Example representation of routes:

```
                         main              ----------------user----------------
	       	        /   \              |                                  |
		       /     \             |                                  |
	      ------home  welcome          login--------             --------register
	     /		\                    |         |             |          |
	    /	         \                   |         |             |          |
	  about     dashboard               form    activate      activate     form
```

## URL

There are different modes to create and manage URL internaly in the framework.

The mode of the `$GLOBALS['Router']` will be the same for all the script.

To access a route `form` in a route `login` in a route `user` with parameter
`nickname=gugus2000`, the URL will be:

### Router mode: get

`<WEBSITE_DOMAIN>?__path=login/user/form&name=gugus2000`

### Router mode: mixed

`<WEBSITE_DOMAIN>/login/user/form/?name=gugus2000`

### Router mode: route

`<WEBSITE_DOMAIN>/login/user/form/ /gugus2000`

## Configuration

The preferred (default) Router mode can be configurated,
