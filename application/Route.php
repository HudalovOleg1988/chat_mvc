<?php
	class Route
	{

		static $page;

		static function start()
		{
			$url  = explode("/", $_SERVER['REQUEST_URI']);
			self::$page = "login";
			$action = "index";
			$slug = "";

			if (!empty($url[1]))
				self::$page = $url[1];

			if (!empty($url[2]))
				$action = $url[2];

			if (!empty($url[3]))
				$slug = $url[3];

			$controller = self::$page."_controller";
			$model = self::$page."_model";

			if (file_exists($incc = $_SERVER['DOCUMENT_ROOT']."/application/controllers/".strtolower($controller).".php")) {
				include $incc;
			}
			else {
				header("Location: /page_404");
				exit;
			}

			if (file_exists($incc = $_SERVER['DOCUMENT_ROOT']."/application/models/".strtolower($model).".php")) {
				include $incc;
			}

			$controller_obj = new $controller();

			if (method_exists($controller_obj,$action)) {
				$controller_obj->$action();
			}
			else {
				header("Location: /page_404");
				exit;
			}
		}

	}
?>