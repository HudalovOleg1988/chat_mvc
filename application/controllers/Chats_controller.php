<?php
	include $_SERVER['DOCUMENT_ROOT']."/application/core/chat.php";

	class Chats_controller extends Controller {

		use Chat;

		public function __construct() {
			parent::__construct();
			//рповерка авторизации
			$this->if_not_isset_login();
			//создание модели
			$this->chats_model = new Chats_model();
			$this->chat_model = new Chat_model();
			//название для placeholder
			$this->data['placeholder'] = "search chat";
			$this->data['title'] = "Chats";

			//запрос списка чатов
			$this->data['chats'] = $this->chats_model->get_chats();
			//запрос последнего сообщения для каждого чата
			if (!empty($this->data['chats'])) {
				for ($i=0; $i < COUNT($this->data['chats']); $i++) {
					$message = $this->chats_model->get_last_chats_message($this->data['chats'][$i]['chatId']);
					if (!empty($message)) {
						$this->data['chats'][$i]['message'] = $message['message'];
						$this->data['chats'][$i]['message_time'] = $message['messagetime'];
						$this->data['chats'][$i]['view'] = $message['view'];
					}
				}
			}
		}
		public function index() {
			$this->view("chats",$this->data);
		}

	}

?>