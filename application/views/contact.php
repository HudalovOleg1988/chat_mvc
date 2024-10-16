<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$data['title'];?></title>
	<link rel="stylesheet" href="/assets/css/chat.css">
</head>
<body>
	<div class="main">
		<!-- СЙАТБАР -->
		<div class="sitebar">

			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/nav.php";?>
			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->

			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/search_form.php";?>
			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->
			
			<!-- СПИСОК КОНТАКТОВ -->
			<?php if (!empty($data['users'])): ?>
				<?php foreach ($data['users'] as $user_item): ?>
					<a href="/contact/chat/?user=<?=$user_item['userId'];?><?php if(isset($_GET['search'])) echo '&search='.$_GET['search'];?>" class="sitebar_user">
						<div class="sitebar_user_avatar" style="background: url('/assets/img/<?=$user_item['avatar'];?>') no-repeat center center; background-size: cover;">
						</div>
						<div class="sitebar_user_name"><?=$user_item['name'];?></div>
						<div class="sitebar_user_nic"><?=$user_item['nic'];?></div>
						<div class="sitebar_user_nic"><?=$user_item['email'];?></div>
					</a>
				<?php endforeach ?>
			<?php endif ?>
			<!-- СПИСОК КОНТАКТОВ -->
		</div>
		<!-- СЙАТБАР -->

		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/chat.php";?>
		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->

		<!-- ПОДКЛЮЧЕНИЕ WARNING -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/application/views/templates/warning.php";?>
		<!-- ПОДКЛЮЧЕНИЕ WARNING -->

	</div>
</body>
</html>