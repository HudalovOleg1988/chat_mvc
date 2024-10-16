<?php

	include $_SERVER['DOCUMENT_ROOT']."/application/models/chat_model.php";

	trait Chat {

		public function chat() {
			//пустое значение
			if ($_GET['user']=="") $this->redirect("/".Route::$page);
			//запрос информации о пользователе
	  		$this->data['user'] = $this->chat_model->get_user($_GET['user']);
			if (empty($this->data['user'])) $this->redirect("/".Route::$page);
			//запрос совместного чата с этим пользователем
			$this->data['chat'] = $this->chat_model->get_chat($this->data['user']['userId']);
			//запрос сообщений чата
			if (in_array($this->data['user']['userId'],$_SESSION['contacts']) && !empty($this->data['chat'])) {
				//указать что опонент является контактом
				$this->data['contact'] = true;
				// запрос сообщений чата
				$this->data['messages'] = $this->chat_model->get_chats_messages($this->data['chat']['chatId']);
				//проставить просмотренно в присланных сообщениях
				$this->chat_model->set_view_chats_messages($this->data['chat']['chatId']);
			} else $this->data['contact'] = false;

			$this->view(Route::$page,$this->data);
		}

		public function send_message() {
			//наличие значения
			if ($_POST['user']=="") $this->redirect("/".Route::$page."/index");
			//является ли контактом
			if (!in_array($_POST['user'],$_SESSION['contacts'])) $this->redirect("/".Route::$page."/index");
			//наличия сообщения
			if ($_POST['message']=="") {
				if ($_POST['search']!="") $this->redirect("/".Route::$page."/chat/?user=".$_POST['user']."&search=".$_POST['search']);
				else $this->redirect("/".Route::$page."/chat/?user=".$_POST['user']);
			}
			//проверка наличия чата у меня, если нет - создать
			$chat = $this->chat_model->get_chat($_POST['user']);
			if (!empty($chat)) $chat_user_id = $chat['chatId'];
			else {
				$this->chat_model->set_user_chat($_POST['user']);
				$chat_user_id = $this->chat_model->get_last_insert_id();
			}

			//проверка наличия чата у опонента, если нет - создать
			$chat = $this->chat_model->get_contact_chat($_POST['user']);
			if (!empty($chat)) $chat_oponent_id = $chat['chatId'];
			else {
				$this->chat_model->set_contact_chat($_POST['user']);
				$chat_oponent_id = $this->chat_model->get_last_insert_id();
			}

			//вносим сообщение в БД
			$this->chat_model->set_message($_POST['message']);
			$message_id = $this->chat_model->get_last_insert_id();
			//привязываем сообщение к моему чату
			$this->chat_model->set_message_to_chat($chat_user_id,$message_id);
			//привязываем сообщение к чату опонента
			$this->chat_model->set_message_to_chat($chat_oponent_id,$message_id);
			//проставить последние обновления в чатах
			$this->chat_model->chat_last_update($chat_user_id);
			$this->chat_model->chat_last_update($chat_oponent_id);

			if ($_POST['search']!="") $this->redirect("/".Route::$page."/chat/?user=".$_POST['user']."&search=".$_POST['search']);
			else $this->redirect("/".Route::$page."/chat/?user=".$_POST['user']);
		}

		public function clean_messages_warning() {
			//наличие значения
			if ($_GET['clean_messages_warning'] == "") $this->redirect("/".Route::$page);
			//проверка контакта
			if (!in_array($_GET['clean_messages_warning'],$_SESSION['contacts'])) $this->redirect("/".Route::$page);
			//запрос информации о пользователе
			$this->data['user']=$this->chat_model->get_user($_GET['clean_messages_warning']);
			
			$this->view("chats",$this->data);
		}

		public function clean_messages() {
			//пустое значение
			if ($_GET['clean_messages'] == "") $this->redirect("/".Route::$page);
			//проверка контакта
			if (!in_array($_GET['clean_messages'],$_SESSION['contacts'])) $this->redirect("/".Route::$page);
			//запрос id чата с опонентом
			$chat = $this->chat_model->get_chat($_GET['clean_messages']);
			//удаление сообщений чата
			//запрос id всех сообщений относящихся к чату
			$messages_id = $this->chat_model->get_messages_id($chat['chatId']);
			if (empty($messages_id)) $this->redirect("/".Route::$page);
			//удаление связки чата с удаляемыми сообщениями
			foreach ($messages_id as $i) {$this->chat_model->delete_message_from_chat($chat['chatId'],$i['textId']);}
			//удаление или update сообщений
			foreach ($messages_id as $i) {
				if ($i['chats']==2) $this->chat_model->update_message($i['textId']);
				else $this->chat_model->delete_message($i['textId']);
			}
			//проверка наличия поискового запроса для редиректа
			if (isset($_GET['search'])) $this->redirect("/".Route::$page."/chat/?user=".$_GET['clean_messages']."&search=".$_GET['search']);
			else $this->redirect("/".Route::$page."/chat/?user=".$_GET['clean_messages']);
		}

		public function drop_chat_warning() {
			//наличие значения
			if ($_GET['drop_chat_warning'] == "") $this->redirect("/".Route::$page);
			//проверка контакта
			if (!in_array($_GET['drop_chat_warning'],$_SESSION['contacts'])) $this->redirect("/".Route::$page);
			//запрос информации о пользователе
			$this->data['user']=$this->chat_model->get_user($_GET['drop_chat_warning']);

			$this->view("chats",$this->data);
		}

		public function drop_chat() {
			//наличие значения
			if ($_GET['drop_chat'] == "") $this->redirect("/".Route::$page);
			//проверка контакта
			if (!in_array($_GET['drop_chat'],$_SESSION['contacts'])) $this->redirect("/".Route::$page);
			//запросить id чата
			$chatId = $this->chat_model->get_delete_chat_id($_GET['drop_chat']);
			if (empty($chatId)) $this->redirect("/".Route::$page);
			//запросить сообщения чата
			$messages = $this->chat_model->get_message_for_delete($chatId['chatId']);
			//удалить связку сообщений с чатом
			$this->chat_model->delete_chat_messages($chatId['chatId']);
			//удалить сообщения чата привязанные к одному чату или сделать update
			foreach ($messages as $i) {
				$i['chats']." ";
				if ($i['chats']==2) $this->chat_model->update_message($i['textId']);
				else $this->chat_model->delete_message($i['textId']);
			}
			//удалить чат
			$this->chat_model->delete_chat($chatId['chatId']);

			//проверка наличия поискового запроса для редиректа
			if (isset($_GET['search'])) $this->redirect("/".Route::$page."/index/?search=".$_GET['search']);
			else $this->redirect("/".Route::$page);
		}

		public function add_contact() {
			if ($_GET['add_contact']=="") $this->redirect("/".Route::$page);
				//проверить наличие пользователя
				$user_contact = $this->chat_model->get_user($_GET['add_contact']);
				if (empty($user_contact)) $this->redirect("/".Route::$page);
				//проверить наличие контакта с этим пользователем
				$contact = $this->chat_model->check_isset_contact($_GET['add_contact']);

				if (empty($contact)) {
					//внесение контакта
					$this->chat_model->set_contact($_GET['add_contact']);
					//обновление сессии
					$_SESSION['contacts'][] = $_GET['add_contact'];
				}
				//проверка наличия поискового запроса для редиректа
				if (isset($_GET['search'])) $this->redirect("/".Route::$page."/chat/?user=".$_GET['add_contact']."&search=".$_GET['search']);
				else $this->redirect("/".Route::$page."/chat/?user=".$_GET['add_contact']);
		}

		public function delete_contact() {
			//наличие значения
			if ($_GET['delete_contact']=="") $this->redirect("/".Route::$page);
			//удаление из БД
			$this->chat_model->delete_contact($_GET['delete_contact']);
			//удаление контакта из массива сессии
			foreach ($_SESSION['contacts'] as $key=>$contactId) {
				if ($_GET['delete_contact']==$contactId) unset($_SESSION['contacts'][$key]);
			}

			if (isset($_GET['search'])) $this->redirect("/".Route::$page."/chat/?user=".$_GET['delete_contact']."&search=".$_GET['search']);
			else $this->redirect("/".Route::$page."/chat/?user=".$_GET['delete_contact']);
		}

	}

?>