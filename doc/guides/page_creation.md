# Page creation

This tutorial will guide you to create a demo webpage which will look like this: [img]

## Folder

To store page script, we'll create the folder named `welcome` in [`page/main/`](../../src/page/main/).

## `page.php`

Inside, we'll create a file `page.php`, which will contains script that will run when loading this webpage.

Content of `page.php`:

```php
$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

// avoid repetitive work
$template_dir = 'main' . DIRECTORY_SEPARATOR . 'welcome' . DIRECTORY_SEPARATOR;
$locale = $GLOBALS['locale']['page']['main']['welcome'];

$head = new \content\pageelement\PageElement([
	'template' => $template_dir . 'head.html',
	'elements' => [
		'title' => $locale['title'],
	],
]);

$body = new \content\pageelement\PageElement([
	'template' => $template_dir . 'body.html',
	'elements' => [
		'title_message' => $locale['title_message'],
		'main_content'  => $locale['main_content'],
		'link_content'  => $locale['link_content'],
		'link_title'    => $locale['link_title'],
	],
]);

// add these elements
$PageElement->addElement('head', $head);
$PageElement->addElement('body', $body);
```

Let's explains what's going on !

```php
$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');
```

This first line will store the `\content\pageelement\PageElement` (PHP object which store content) in a variable named `$PageElement`.

```php
// avoid repetitive work
$template_dir = 'main' . DIRECTORY_SEPARATOR . 'welcome' . DIRECTORY_SEPARATOR;
$locale = $GLOBALS['locale']['page']['main']['welcome'];
```

These two lines are useful to avoid writing same thing again and again by declaring variable. We we'll using their content many time in this script.

```php
$head = new \content\pageelement\PageElement([
	'template' => $template_dir . 'head.html',
	'elements' => [
		'title' => $locale['title'],
	],
]);
```

The default html preset, which will be used here, has two elements: a body and an header, like the traditionnal html structure.

Create a new `\content\pageelement\PageElement` which will contains the html head of the page.

Some parameters to construct this object can be seen:

- template, which will contains a **relative** path from [`asset/template/`](../../src/asset/template) to the html template. For now, no template file has been created, for this page to work,
they'll need to be created.
- contents, which is a key => value array to put content in available elements. `$locale`, which was declared before, is used here. For now, no locale file define these value, they will be created
later.

Next, `$body` is defined the same way as `$head`.

```php
// add these elements
$PageElement->addElement('head', $head);
$PageElement->addElement('body', $body);
```

Finally, `$body` and `$head` has to be added as body and head element of `$PageElement`, which have been defined before as the main `\content\pageelement\PageElement` of this page.

That what these last lines do.

## templates

Now, let's create the templates files used in `page.php`.

### `head.html`

`asset/template/main/welcome/head.html` content:

```html
<title>{title}</title>
```

Word between `{` and `}` are element, their content are defined in the PHP script. That's why `title` element is the only one defined in `page.php` for `$head`.

### `body.html`

```html
<h1>{title_message}</h1>
<p>{main_content}</p>
<small><a href="/" title="{link_title}">{link_content}</a></small>
```

Same thing than before, it's interesting to see how this file is linked with the `$body` definition in `page.php`.

## locale file

`page.php` use some content in `$GLOBALS['locale']['page']['main']['welcome']`, which does not exist, let's resolve that!

`locale/page/main/welcome/en.locale.php` will be the file that will define this array so `page.php` will use existing value.

`locale/page/main/welcome/en.locale.php` content:

``` php
/* title of the page */
$GLOBALS['locale']['page']['main']['welcome']['title'] = 'Welcome !';
/* title displayed in the content */
$GLOBALS['locale']['page']['main']['welcome']['title_message'] = 'Welcome to the demo page !';
/* main content */
$GLOBALS['locale']['page']['main']['welcome']['main_content'] = 'This is a demo webpage to guide you through simple PHosPhore\'s page creation';
/* text displayed as a link */
$GLOBALS['locale']['page']['main']['welcome']['link_content'] = 'Return to the main page';
/* title (text displayed when link hovered) to the link */
$GLOBALS['locale']['page']['main']['welcome']['link_title'] = 'Return to the root of this website';
```

File named like this (following the same folder convention as in [`page/`](../../src/page) will be autoloaded at the page loading, and will define locale value for english people. You can
create another file like `<abbr>.locale.php` where `<abbr>` is a language tag as defined in [rfc 5646](https://www.rfc-editor.org/rfc/rfc5646.txt) which define the same key with value in
the correct language.

## Database

All files are now created ! The last thing to do is to define database entries so the router system can display this new page with an (or more) URL of your choice.

### PHPMyAdmin / dbeaver or other graphic tools

If you have graphical database management system already installed, you can easily add entries at these tables in your PHosPhore's database:

- `phosphore_folder` table: insert a new entry with name 'welcome' (name of the directory created at the first step) and id_parent as the `main` entry id (should be 2) because `welcome` folder is inside `main` folder.
- `phosphore_route` table: insert a new entry with name 'welcome' (URL string which will be writed to access the webpage) and type as 1 (it's a page and not a node containing other page).
- `phosphore_link_route_route` table: insert a new entry with id_route_parent as the `main` route id (should be 2) and id_route_child as the new route id of the 'welcome' entry.
- `phosphore_permission` table: insert a new entry with id_route as the `welcome` route and name_role as 'all'

### With PHosPhore

You can temporary add line in the main `page.php` ([`page/main/home/page.php](../../src/page/main/home/page.php) by default, after `$PageElement->addElement('body', $body)` for example:

```php
$MainFolder = new \route\Folder([
	'name'      => 'main',
	'id_parent' => -1,
]);
$MainFolder->retrieve();

$WelcomeFolder = new \route\Folder([
	'name'      => 'welcome',
	'id_parent' => $MainFolder->get('id');
]);
$WelcomeFolder->add();

$WelcomeRoute = new \route\Route([
	'name' => 'welcome',
	'type' => \route\Route::TYPES['page'],
]);
$WelcomeRoute->add();

$MainRoute = new \route\Route([
	'name' => 'main',
	'type' => \route\Route::TYPES['folder'],
]);
$MainRoute->retrieve();

$LinkRouteRoute = new \user\LinkRouteRoute();
$LinkRouteRoute->add([
	'id_route_parent' => $MainRoute->get('id'),
	'id_route_child'  => $WelcomeRoute->get('id'),
]);

$WelcomePermission = new \user\Permission([
	'id_route'  => $WelcomeRoute->get('id'),
	'name_role' => 'all',
]);
$WelcomePermission->add();
```

Once it's done, load the page **one time**, and **delete it immediately after**.

## Congratulation

You can now access welcome page at `<SERVER URL>/welcome` or `<SERVER URL>/main/welcome`.
