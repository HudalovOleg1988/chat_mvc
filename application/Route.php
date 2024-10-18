<?php
	class Route
	{

		static $page;
		static $slug;
		static $action;

		static function start()
		{
			$url  = explode("/", $_SERVER['REQUEST_URI']);
			self::$page = "login";
			self::$action = "index";
			self::$slug = "";

			if (!empty($url[1]))
				self::$page = $url[1];

			if (!empty($url[2]))
				self::$action = $url[2];

			if (!empty($url[3]))
				self::$slug = $url[3];

			$action = self::$action;

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

			if (method_exists($controller_obj,self::$action)) {
				$controller_obj->$action();
			}
			else {
				header("Location: /page_404");
				exit;
			}
		}

	}
?>