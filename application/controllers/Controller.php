<?php
	include $_SERVER['DOCUMENT_ROOT']."/application/models/model.php";
	
	class Controller {

		public $data = array();

		public function __construct() {
			//создание модели
			$this->model = new Model();
			//колличество непрочитанных сообщений
			$this->data['messageCount'] = $this->model->get_new_message_count();
		}

		public function redirect($query) {header("Location: ".$query);exit;}

		public function if_not_isset_login() { 
			if (!$_SESSION['login']) $this->redirect("/login");
		}

		public function if_isset_login() {
			if (isset($_SESSION['login']) && $_SESSION['login']) $this->redirect("/chats");
		}
		
		public function view($page,$data=null) {
			include $_SERVER['DOCUMENT_ROOT']."/application/views/$page.php";
		}

	}


?>



















