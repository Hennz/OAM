<?php
Class Bootstrap{
	public function __construct() {
		$url = $_GET['url'];
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			$file = 'controller/home.php';
			require $file;
			$className = 'HomeController';
			$controller = new $className;
		} else {
			$file = 'controller/'.$url[0].'.php';
			if (file_exists($file)) {
				require $file;
				$className = $url[0].'Controller';
				$controller = new $className;
			} else {
				throw new Exception('The file: '. $file. ' does not exist.');
			}
		}

		if (isset($url[2])) {
		 	$controller->{$url[1]}($url[2]);
		} else {
			if (isset($url[1]))
		 		$controller->{$url[1]}();
		 	else
		 		$controller->index();
		}
	}
}