<?php

	class Search_model extends Db {

		public function __construct() {
			self::db();
		}

		public function get_users() {
			$sql = "SELECT * FROM users WHERE NOT userId=".$_SESSION['user_id'];
			if (isset($_GET['search'])) {
				$search = $_GET['search'];
				$sql = "SELECT * FROM users WHERE name LIKE '%$search%' OR nic LIKE '%$search%' OR email LIKE '%$search%'";
			}
			return self::query($sql, null, "fetchAll" );
		}

	}

?>