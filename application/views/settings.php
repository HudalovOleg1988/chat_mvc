<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$data['title'];?></title>
	<link rel="stylesheet" href="/assets/css/chat.css">
</head>
<body>
	<div class="main">
		<div class="sitebar">

			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/nav.php";?>
			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->

			<form action="/settings/change_avatar" class="form_settings_avatar" enctype="multipart/form-data" method="post">
				<input type="file" id="change_button_avatar" name="avatar">
				<div style="background: url('/assets/img/<?=$_SESSION['avatar'];?>') no-repeat center center; background-size: cover;"></div>
				<a href="/settings/delete_avatar">delete</a>
				<input type="hidden" name="change_avatar">
				<input type="submit" value="change avatar">
			</form>

			<form class="form_settings" method="post" action="/settings/change_name">
				<div class="form_settings_title"><?=$_SESSION['name'];?></div>
				<input type="text" name="name" placeholder="youre name" value="<?php if(isset($_GET['name'])) echo $_GET['name'];?>">
				<input type="submit" value="change name">
			</form>

			<form class="form_settings" method="post" action="/settings/change_nic">
				<div class="form_settings_title"><?=$_SESSION['nic'];?></div>
				<input type="text" name="nic" placeholder="youre nic" value="<?php if(isset($_GET['nic'])) echo $_GET['nic'];?>">
				<input type="submit" value="change nic">
			</form>

			<form class="form_settings" method="post" action="/settings/change_email">
				<div class="form_settings_title"><?=$_SESSION['email'];?></div>
				<input type="text" name="email" placeholder="youre email" value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>">
				<input type="submit" value="change email">
			</form>

			<form class="form_settings" method="post" action="/settings/change_password">
				<div class="form_settings_title">password</div>
				<input type="password" name="old_password" placeholder="old password" value="<?php if(isset($_GET['old_password'])) echo $_GET['old_password'];?>">
				<input type="password" name="new_password" placeholder="new password" value="<?php if(isset($_GET['new_password'])) echo $_GET['new_password'];?>">
				<input type="password" name="confirm" placeholder="confirm" value="<?php if(isset($_GET['confirm'])) echo $_GET['confirm'];?>">
				<input type="submit" value="change password">
				<input type="hidden" name="change_password">
			</form>

			<?php if (isset($_GET['error_message'])): ?>
					<div class="error_message"><?=$_GET['error_message'];?></div>
			<?php endif ?>

			<?php if (isset($_GET['message_edit'])): ?>
					<div class="message-form"><?=$_GET['message_edit'];?></div>
			<?php endif ?>

		</div>
	</div>
</body>
</html>