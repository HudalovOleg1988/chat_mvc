<?php

	class Login_controller extends Controller {

		public function __construct() {
			$this->login_model = new Login_model();
			$this->if_isset_login();
		}

		public function index() {$this->view("login",$this->data);}

		public function siginin() {

			if ($_POST['login'] == "" || $_POST['password'] == "") $this->redirect("/login/index/?error_login=неверный логин или пароль&login=$login");

			//переменные
			$login = $_POST['login'];
			$password = hash('sha256',$_POST['password']);
			$_SESSION['contacts'] = array();

			//запрос пользователя
			$user = $this->login_model->getUser($login,$password);

			//если не зарегистрирован, переадресация на форму
			if ($user['userId']=="") $this->redirect("/login/index/?error_login=неверный логин или пароль&login=$login");

			//запрос контактов пользователя
			$contacts = $this->login_model->getContacts($user['userId']);

			for ($i=0; $i < COUNT($contacts); $i++) $_SESSION['contacts'][$i] = $contacts[$i]['contact'];
			
			$_SESSION['login'] = TRUE;
			$_SESSION['name'] = $user['name'];
			$_SESSION['nic'] = $user['nic'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['user_id'] = $user['userId'];
			$_SESSION['avatar'] = $user['avatar'];
			$this->redirect("/chats");

		}

		public function siginup() {
			//заношу пост значения в переменные
			$name 		= $_POST['name'];
			$nic 		= $_POST['nic'];
			$email 		= $_POST['email'];
			$password 	= $_POST['password'];
			$confirm 	= $_POST['confirm'];
			
			//указываю переменные для редиректа
			$location_value = "name=$name&nic=$nic&email=$email&password=$password&confirm=$confirm&error_siginup=";

			//проверка заполнености всех полей
			if ($name=="" || $nic=="" || $email=="" || $password=="" || $confirm=="") {
				$error = "не все поля заполнены";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка длины имени
			if (!preg_match('/^[\s\S]{1,20}$/',$name)) {
				$error = "имя не должно быть длинее 20 символов";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка формата ник
			if (!preg_match('/^[a-zA_Z0-9.-]{1,20}$/',$nic)) {
				$error = "nic должен быть не более 20 символов и состоять только из латиницы, цифр,.-";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка уникальности ник
			$unique_nic = $this->login_model->getNic($nic);

			if (!empty($unique_nic['nic'])) {
				$error = "данный ник уже занят";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка формата адреса почты
			if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$email)) {
				$error = "некорректный формат электронной почты";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка уникальности адреса почты
			$unique_email = $this->login_model->getEmail($email);

			if (!empty($unique_email['email'])) {
				$error = "данный email уже занят";
				$this->redirect("/login/index/?$location_value $error");
			}

			// проверка формата пароля
			if (!preg_match('/^[\S]{6,20}$/',$password)) {
				$error = "пароль должен состоять минимум из 6 символов, максимум из 20";
				$this->redirect("/login/index/?$location_value $error");
			}

			//проверка совпадения плдтверждения пароля
			if ($password !== $confirm) {
				$error = "пароли не совпадают";
				$this->redirect("/login/index/?$location_value $error");
			}
	  		$password = hash('sha256', $password);
	  		
			//производим решистрацию
			$this->login_model->setUser($name,$nic,$email,$password);
			$this->redirect("/login/index/?message=можете авторизироваться");
		}

	}

?>