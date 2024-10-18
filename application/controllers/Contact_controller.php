<?php

	include $_SERVER['DOCUMENT_ROOT']."/application/core/chat.php";

	class Contact_controller extends Controller {

		use Chat;
		
		public function __construct() {
			parent::__construct();
			//создание модели
			$this->if_not_isset_login();
			$this->contact_model = new Contact_model();
			$this->chat_model = new Chat_model();
			//название плэйсхолдер
			$this->data['placeholder'] = "search contact";
			$this->data['title'] = "Contact";

			$this->data['users']=$this->contact_model->get_contacts();
		}

		public function index() {
			$this->view("contact",$this->data);
		}

	}

?>