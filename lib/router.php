<?php
 
if(strpos($_SERVER['REQUEST_URI'], '?') === false)
{
	$pathList = ['task', 'list'];
}
else
{
	$uriSplit = explode('?', $_SERVER['REQUEST_URI']);
	$pathList = preg_split('/\//', $uriSplit[1], -1, PREG_SPLIT_NO_EMPTY);
	
}

	if (count($pathList) >= 2) {
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
}
