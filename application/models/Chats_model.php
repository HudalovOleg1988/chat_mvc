<?php

	class Chats_model extends Db {

		public function __construct() {
			self::db();
		}

		public function get_chats() {
			//ПОСТРОЕНИЕ ЗАПРОСА В ЗАВИСИМОСТИ ОТ НАЛИЧИЯ ПОИСКОВОГО ЗАПРОСА
			$sql = "SELECT * FROM users INNER JOIN chat ON users.userId=chat.contact WHERE chat.user=:user ORDER BY lastupdate DESC";
			if (isset($_GET['search']))
			{
				$search = $_GET['search'];
				$sql = "SELECT * FROM users INNER JOIN chat ON users.userId=chat.contact WHERE 
				chat.user=:user AND name LIKE '%$search%' OR nic LIKE '%$search%' OR email LIKE '%$search%' 
				ORDER BY lastupdate DESC";
			}
			return self::query( $sql, array(":user"=>$_SESSION['user_id']), "fetchAll" );
		}

		public function get_last_chats_message($chat_id) {
			$sql = "SELECT * FROM message 
				INNER JOIN chat_message ON textId=message_id 
				INNER JOIN chat ON chat_id=chatId 
				WHERE chatId=:chat_id 
				ORDER BY messagetime DESC LIMIT 1";
			return self::query( $sql, array(":chat_id"=>$chat_id), "fetch" );
		}

	}

?>











