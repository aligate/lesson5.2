<?php


if(strpos($_SERVER['REQUEST_URI'], '?') === false)
{
	$pathList = ['task', 'list'];
}
else
{
	$pathList = explode('/', trim($_SERVER['argv'][0], '/'));
	
}
	if (count($pathList) < 2)
	{
	$pathList = ['task', 'list'];
	}
	
	$controller = array_shift($pathList);
	$action = array_shift($pathList);
	
	foreach ($pathList as $i => $value) {
		if ($i % 2 == 0 && isset($pathList[$i + 1])) {
			$params[$pathList[$i]] = $pathList[$i + 1];
			
		}
	}
	$controllerText = $controller . 'Controller';
	$controllerFile = 'controllers/' . ucfirst($controllerText) . '.php';
		
	if (is_file($controllerFile)) {
		include $controllerFile;
		if (class_exists($controllerText)) {
			$controller = new $controllerText($db);
			
			$action = ($_SERVER['REQUEST_METHOD'] == 'POST' ? 'post' : 'get').ucfirst($action);
			if (method_exists($controller, $action)) {
				$controller->$action($params, $_POST);
			}
			
		}
	}
