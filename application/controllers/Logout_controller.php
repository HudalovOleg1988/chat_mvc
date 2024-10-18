<?php

	class Logout_controller extends Controller {

		public function index() {
			unset($_SESSION['login']);
			unset($_SESSION['name']);
			unset($_SESSION['email']);
			unset($_SESSION['nic']);
			unset($_SESSION['user_id']);
			unset($_SESSION['avatar']);
			$this->redirect("/login");
		}
		
	}

?>