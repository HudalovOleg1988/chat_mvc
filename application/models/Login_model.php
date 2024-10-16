<?php

	class Login_model extends Db {

		public function __construct() {
			self::db();
		}

		public function getUser($login,$password) {
	  		$sql = "SELECT * FROM users WHERE password=:password AND nic=:login";
			return self::query( $sql, array(":login"=>$login,":password"=>$password), "fetch" );
		}

		public function getContacts($userId) {
			$sql = "SELECT contact FROM user_contact WHERE user_id=:user_id";
			return self::query( $sql, array(":user_id"=>$userId), "fetchAll" );
		}

		//создать и занести в модель user, так как этот метод встречается во многих моделях
		public function getNic($nic) {
			$sql = "SELECT * FROM users WHERE nic = :nic";
			return self::query( $sql, array(":nic"=>$nic), "fetch" );
		}

		//создать и занести в модель user, так как этот метод встречается во многих моделях
		public function getEmail($email) {
			$sql = "SELECT * FROM users WHERE email = :email";
			return self::query( $sql, array(":email"=>$email), "fetch" );
		}

		public function setUser($name,$nic,$email,$password) {
			$sql = "INSERT INTO users SET name=:name, nic=:nic, email=:email, password=:password, usersdate=now()";
			self::query($sql, array(":name"=>$name,":nic"=>$nic,":email"=>$email,":password"=>$password), null );
		}

	}

?>