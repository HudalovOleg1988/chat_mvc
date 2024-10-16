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

			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/search_form.php";?>
			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->

			<?php if (!empty($data['users'])): ?>
				<?php foreach ($data['users'] as $user): ?>
						<a href="/search/chat/?user=<?=$user['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="sitebar_user">
							<div class="sitebar_user_avatar" style="background: url('/assets/img/<?=$user['avatar'];?>') no-repeat center center; background-size: cover;">
							</div>
							<div><?=$user['name'];?></div>
							<div><?=$user['nic'];?></div>
							<div><?=$user['email'];?></div>
						</a>
				<?php endforeach ?>
			<?php endif ?>

		</div>

		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/chat.php";?>
		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->

		<!-- ПОДКЛЮЧЕНИЕ WARNING -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/warning.php";?>
		<!-- ПОДКЛЮЧЕНИЕ WARNING -->
		
	</div>
</body>
</html>