<?php

	include $_SERVER['DOCUMENT_ROOT']."/application/core/chat.php";

	class Search_controller extends Controller {

		use Chat;

		public function __construct() {
			parent::__construct();
			$this->if_not_isset_login();
			//создание модели
			$this->search_model = new Search_model();
			$this->chat_model = new Chat_model();
			//название для placeholder
			$this->data['placeholder'] = "search users";
			$this->data['title'] = "Search";

			//запрос списка пользователей
			$this->data['users'] = $this->search_model->get_users();
		}

		public function index() {
			$this->view("search",$this->data);
		}

	}

?>