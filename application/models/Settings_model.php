<?php

	class Settings_model extends Db {

		public function change_avatar($avatar) {
	  		$sql = "UPDATE users SET avatar=:avatar WHERE userId=:id";
			self::query( $sql, array(":avatar"=>$avatar,":id"=>$_SESSION['user_id']), null );
		}

		public function delete_avatar() {
	  		$sql = "UPDATE users SET avatar=:avatar WHERE userId=:id";
			self::query( $sql, array(":avatar"=>"",":id"=>$_SESSION['user_id']), null );
		}

		public function change_name($name) {
	  		$sql = "UPDATE users SET name=:name WHERE userId=:userId";
			self::query( $sql, array(":name"=>$name,"userId"=>$_SESSION['user_id']), null );
		}

		public function get_nic($nic) {
	  		$sql = "SELECT * FROM users WHERE nic = :nic";
			return self::query( $sql, array(":nic"=>$nic), "fetch" );
		}

		public function change_nic($nic) {
	  		$sql = "UPDATE users SET nic=:nic WHERE userId=:userId";
			self::query( $sql, array(":nic"=>$nic,":userId"=>$_SESSION['user_id']), null );
		}

		public function get_email($email) {
			$sql = "SELECT * FROM users WHERE email = :email";
			return self::query( $sql, array(":email"=>$email), "fetch" );
		}

		public function change_email($email) {
		  	$sql = "UPDATE users SET email=:email WHERE userId=:userId";
			self::query( $sql, array(":email"=>$email,":userId"=>$_SESSION['user_id']), null );
		}

		public function get_password() {
	  		$sql = "SELECT password FROM users WHERE userId = :userId";
			return self::query( $sql, array(":userId"=>$_SESSION['user_id']), "fetch" );
		}

		public function change_password($password) {
	  		$sql = "UPDATE users SET password=:password WHERE userId=:userId";
			self::query( $sql, array(":password"=>$password,":userId"=>$_SESSION['user_id']), null );
		}

	}

?>