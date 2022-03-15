# Page creation

This tutorial will guide you to create a demo webpage which will look like this: [img]

## Folder

To store page script, we'll create the folder named `welcome` in [`page/main/`](../../../src/page/main/).

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

- template, which will contains a **relative** path from [`asset/template/`](../../../src/asset/template) to the html template. For now, no template file has been created, for this page to work,
they'll need to be created.
- contents, which is an key => value array to put content in available elements. `$locale`, which was declared before, is used here. For now, no locale file define these value, they will be created
later.

Next, `$body` is defined the same way as `$head`.

```php
// add these elements
$PageElement->addElement('head', $head);
$PageElement->addElement('body', $body);
```

Finally, `$body` and `$head` has to be added as body and head element of `$PageElement`, which have been defined before as the main `\content\pageelement\PageElement` of this page.

That what these last lines do.
