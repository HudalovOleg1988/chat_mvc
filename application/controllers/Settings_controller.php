<?php

	class Settings_controller extends Controller {

		public function __construct() {
			parent::__construct();
			$this->if_not_isset_login();
			//создание модели
			$this->settings_model = new Settings_model();
			$this->data['title'] = "Settings";
		}

		public function index() {
			$this->view("settings",$this->data);
		}

		public function change_avatar() {
			//проверка формата файла
			if ($_FILES['avatar']['type'] != "image/gif" && 
				$_FILES['avatar']['type'] != "image/jpg" && 
				$_FILES['avatar']['type'] != "image/jpeg" &&
				$_FILES['avatar']['type'] != "image/png") {
				$this->redirect("/settings/index/?error_message=доспукается тип файла gif,jpeg");
			}
			//удаление старого аватара из папки
			$old_avatar = $_SERVER['DOCUMENT_ROOT']."/assets/img/".$_SESSION['avatar'];
			if (is_file($old_avatar)) unlink($old_avatar);
			//создание уникального имени
			$avatar = hash("sha256", rand()).time().$_SESSION['user_id'].'.jpg';
			//заносение файла в папку
			move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/assets/img/".$avatar);
			//заносим уникальной имя файла в БД
			$this->settings_model->change_avatar($avatar);
			//обновление сесси аватара
			$_SESSION['avatar'] = $avatar;
			$this->redirect("/settings/index/?message_edit=аватар обновлен");
		}

		public function delete_avatar() {
			//наличия значения
			if ($_SESSION['avatar'] == "") $this->redirect("/settings/index/?error_message=у вас нет аватара");
			//удаление из папки
			$old_avatar = $_SERVER['DOCUMENT_ROOT']."/assets/img/".$_SESSION['avatar'];
			if (is_file($old_avatar)) unlink($old_avatar);
		  	//удаление из базы данных
			$this->settings_model->delete_avatar();
			//удаление из сесси
		  	$_SESSION['avatar'] = "";
			$this->redirect("settings/index/?message_edit=аватар удален");
		}

		public function change_name() {
			$name = $_POST['name'];
			//проверка наличия и формата значения
			if (!preg_match('/^[\s\S]{1,20}$/',$name)) $this->redirect("/settings/index/?error_message=имя должно содержать от 1 до 20 символов&name=$name");
			//обновление имени в БД
			$this->settings_model->change_name($name);
			//обновление сесси имени
			$_SESSION['name'] = $name;
			$this->redirect("/settings/index/?message_edit=имя измененно");
		}

		public function change_nic() {
			$nic = $_POST['nic'];
			//проверка наличия и формата ник
			if (!preg_match('/^[a-zA_Z0-9.-]{1,20}$/',$nic)) $this->redirect("/settings/index/?error_message=nic должен быть не более 20 символов и состоять только из латиницы, цифр,.-;&nic=$nic");
			//проверка уникальности ник
			$unique_nic = $this->settings_model->get_nic($nic);
			if (!empty($unique_nic['nic'])) $this->redirect("/settings/index/?error_message=данный ник уже занят&nic=$nic");
			//обновление в БД
			$this->settings_model->change_nic($nic);
			//обновление сессии
			$_SESSION['nic'] = $nic;
			$this->redirect("/settings/index/?message_edit=nic измененно");
		}

		public function change_email() {
			$email = $_POST['email'];
			//проверка наличия значеия и формата электронной почты
			if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$email)) $this->redirect("/settings/index/?error_message=некорректный формат электронной почты&email=$email");
			//проверка уникальности адреса почты
			$unique_email = $this->settings_model->get_email($email);
			if (!empty($unique_email['email'])) {
				$error = "данный email уже занят";
				$this->redirect("/settings/index/?error_message=данный email уже занят&email=$email");
			}
			//обновление в БД
			$this->settings_model->change_email($email);
			//обновление сессии
			$_SESSION['email'] = $email;
			$this->redirect("/settings/index/?message_edit=email изменен");
		}

		public function change_password() {
			//запрос прежнего пароля для сверки с введенным
			$password = $this->settings_model->get_password();
			$password = $password['password'];
			//значеия полей формы
			$old_password = hash('sha256',$_POST['old_password']);
			$new_password = $_POST['new_password'];
			$confirm = $_POST['confirm'];
			//проверка заполнености всех полей
			if ($old_password == "" || $new_password == "" || $confirm == "") $this->redirect("/settings/index/?error_message=не все поля заполнены&new_password=$new_password&confirm=$confirm");
			//проверка старого пароля
			if ($password !== $old_password) $this->redirect("/settings/index/?error_message=старый пароль указан неверно&new_password=$new_password&confirm=$confirm");
			//проверка формата пороля
			if (!preg_match('/^[\S]{6,20}$/',$new_password)) $this->redirect("/settings/index/?error_message=пароль должен состоять минимум из 6 символов, максимум из 20&new_password=$new_password&confirm=$confirm");
			//проверка подтверждения пароля
			if ($new_password !== $confirm) $this->redirect("/settings/index/?error_message=пароли не совпадают&new_password=$new_password&confirm=$confirm");
			//изменение пароля в базе данных
			$new_password = hash('sha256',$new_password);
			$this->settings_model->change_password($new_password);
			$this->redirect("/settings/index/?message_edit=пароль изменен");
		}

	}

?>