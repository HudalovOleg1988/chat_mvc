<?php

	class Chat_model extends Db {

		public function get_user($user) {
			$sql = "SELECT * FROM users WHERE userId=:user";
			return self::query( $sql, array(":user"=>$user), "fetch" );
		}

		public function get_chat($user) {
			$sql = "SELECT * FROM chat WHERE user=:user AND contact=:contact";
			return self::query( $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$user), "fetch" );
		}

		public function get_chats_messages($chatId) {
			$sql = "SELECT * FROM message INNER JOIN chat_message ON message.textId=chat_message.message_id 
  				WHERE chat_message.chat_id=:chat_id ORDER BY messagetime DESC";
				return self::query( $sql, array(":chat_id"=>$chatId), "fetchAll" );
		}

		public function set_view_chats_messages($chatId) {
			$sql = "UPDATE message 
					INNER JOIN chat_message ON message.textId=chat_message.message_id
					INNER JOIN chat ON chat_message.chat_id=chat.chatId
					SET message.view=1 
					WHERE chatId=:chat_id AND NOT user_id=:me";
			self::query( $sql, array(":me"=>$_SESSION['user_id'],":chat_id"=>$chatId), null );
		}

		public function set_user_chat($user) {
	  		$sql = "INSERT INTO chat SET chatdate=now(), lastupdate=now(), user=:me, contact=:contact";
			self::query( $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$user), null );
		}

		public function get_last_insert_id() {
			return self::$pdo->lastInsertId();
		}

		public function get_contact_chat($user) {
			$sql = "SELECT * FROM chat WHERE user=:contact AND contact=:me";
			return self::query( $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$user), "fetch" );
		}

		public function set_contact_chat($user) {
			$sql = "INSERT INTO chat SET chatdate=now(), lastupdate=now(), user=:contact, contact=:me";
			return self::query( $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$user), null );
		}

		public function set_message($message) {
			$sql = "INSERT INTO message SET message=:message, messagetime=now(), view=0, chats = 2, user_id=:user_id";
			self::query( $sql, array(":message"=>$message,":user_id"=>$_SESSION['user_id']), null );
		}

		public function set_message_to_chat($chatId,$messageId) {
			$sql = "INSERT INTO chat_message SET chat_id=:chat_id, message_id=:message_id";
			self::query( $sql, array(":chat_id"=>$chatId,":message_id"=>$messageId), null );
		}

		public function chat_last_update($chatId) {
			$sql = "UPDATE chat SET lastupdate = now() WHERE chatId=:chat_id";
			self::query( $sql, array(":chat_id"=>$chatId), null );
		}

		public function get_messages_id($chatId) {
			$sql = "SELECT textId,chats FROM message 
					INNER JOIN chat_message ON textId=message_id
					INNER JOIN chat ON chat_id=chatId
					WHERE chatId=:chat_id";
			return self::query( $sql, array(":chat_id"=>$chatId), "fetchAll" );
		}

		public function delete_message_from_chat($chatId,$textId) {
			$sql="DELETE FROM chat_message WHERE chat_id=:chat_id AND message_id=:message_id";
			self::query( $sql, array(":chat_id"=>$chatId,":message_id"=>$textId), null );
		}

		public function update_message($textId) {
			$sql="UPDATE message SET chats=1 WHERE textId=:textId";
			self::query( $sql, array(":textId"=>$textId), null );
		}

		public function delete_message($textId) {
			$sql="DELETE FROM message WHERE textId=:text_id";
			self::query( $sql, array(":text_id"=>$textId), null );
		}

		public function get_delete_chat_id($contact) {
			$sql="SELECT chatId FROM chat WHERE user=:user AND contact=:contact";
			return self::query( $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$contact), "fetch" );
		}

		public function get_message_for_delete($chatId) {
			$sql="SELECT * FROM message INNER JOIN chat_message ON textId=message_id WHERE chat_id=:chat_id";
			return self::query( $sql, array(":chat_id"=>$chatId), "fetchAll" );
		}

		public function delete_chat_messages($chatId) {
			$sql="DELETE FROM chat_message WHERE chat_id=:chat_id";
			self::query( $sql, array(":chat_id"=>$chatId), null );
		}

		public function delete_chat($chatId) {
			$sql="DELETE FROM chat WHERE chatId=:chatId";
			self::query( $sql, array(":chatId"=>$chatId), null );
		}

		public function check_isset_contact($contact) {
	  		$sql = "SELECT * FROM user_contact WHERE user_id=:user_id AND contact=:contact";
			return self::query( $sql, array(":user_id"=>$_SESSION['user_id'],":contact"=>$contact), "fetch" );
		}

		public function set_contact($contact) {
	  		$sql = "INSERT INTO user_contact SET user_id=:user, contact=:contact";
			self::query( $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$contact), null );
		}

		public function delete_contact($contact) {
	  		$sql = "DELETE FROM user_contact WHERE user_id=:me AND contact=:contact";
			self::query( $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$contact), null );
		}

	}

?>