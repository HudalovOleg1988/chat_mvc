<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Auth</title>
	<link rel="stylesheet" href="/assets/css/chat.css">
</head>
<body>
	<div class="main">
		<div class="sitebar">

			<form method="post" action="/login/siginin">
				<div>enter</div>
				<input type="text" name="login" placeholder="email or nic" value="<?php if(isset($_GET['login'])) echo $_GET['login'];?>">
				<input type="password" name="password" placeholder="password">
				<input type="submit" value="enter">
				<input type="hidden" name="siginin">
				<?php if (isset($_GET['error_login'])): ?>
					<div class="error_form"><?=$_GET['error_login'];?></div>
				<?php endif ?>
			</form>

			<form method="post" action="/login/siginup">
				<div>create account</div>
				<input type="text" name="name"placeholder="name" value="<?php if(isset($_GET['name'])) echo $_GET['name'];?>">
				<input type="text" name="nic" placeholder="nic" value="<?php if(isset($_GET['nic'])) echo $_GET['nic'];?>">
				<input type="text" name="email"placeholder="email" value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>">
				<input type="password" name="password" placeholder="password" value="<?php if(isset($_GET['password'])) echo $_GET['password'];?>">
				<input type="password" name="confirm" placeholder="confirm password" value="<?php if(isset($_GET['confirm'])) echo $_GET['confirm'];?>">
				<input type="submit" value="create account">
				<input type="hidden" name="siginup">
				<?php if (isset($_GET['error_siginup'])): ?>
					<div class="error_form"><?=$_GET['error_siginup'];?></div>
				<?php endif ?>
			</form>
			<?php if (isset($_GET['message'])): ?>
					<div class="message_form"><?=$_GET['message'];?></div>
			<?php endif ?>

		</div>
	</div>
</body>
</html>