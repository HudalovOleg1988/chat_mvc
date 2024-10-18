<?php

	class Contact_model extends Db {

		public function get_contacts() {
			$sql = "SELECT * FROM users INNER JOIN user_contact ON userId=contact WHERE TRUE";
			if (isset($_GET['search'])) {
				$search = $_GET['search'];
				$sql .= " AND email LIKE '%$search%' OR nic LIKE '%$search%' OR name LIKE '%$search%'";
			}
			$sql .= " AND user_id=:user_id";
			return self::query( $sql, array(":user_id"=>$_SESSION['user_id']), "fetchAll");
		}

	}

?>