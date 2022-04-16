<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['main']['home']['title'] . '</title>');

$body = new \content\pageelement\PageElement([
	'template' => 'main' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'body.html',
	'elements' => [
		'message' => $GLOBALS['locale']['page']['main']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	],
]);
$PageElement->addElement('body', $body);

$RouteManager = new \route\RouteManager();
$Tree = new \structure\Tree($RouteManager->retrieveBy([
	'id' => 1,
])[0]);

getChildren($Tree->get('root'));

function getChildren($Node)
{
	$LinkRouteRoute = new \route\LinkRouteRoute();
	$results = $LinkRouteRoute->retrieveby([
		'id_route_parent' => $Node->get('data')->get('id'),
	],
	class_name: '\\route\\Route',
	attributes_conversion: ['id_route_child' => 'id'],
	);
	if (\phosphore_count($results) === 0)
	{
		return False;
	}
	foreach ($results as $route)
	{
		$ChildNode = new \structure\Node($route);
		getChildren($ChildNode);
		$Node->addChild($ChildNode);
	}
	return True;
}

echo $Tree->display()

?>
