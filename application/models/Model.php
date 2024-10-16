<?php

	class Model extends Db {

		public function __construct() {
			self::db();
		}

		public function get_new_message_count() {
			$sql="	SELECT * FROM message 
				INNER JOIN chat_message ON textId=message_id 
				INNER JOIN chat ON chat_id=chatId  
				WHERE user=:user AND view=0 AND NOT user_id=:user_id";
			return self::query($sql, array(":user"=>$_SESSION['user_id'],":user_id"=>$_SESSION['user_id']), "fetchAll" );
		}

	}
?>