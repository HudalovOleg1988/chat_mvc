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

			<!-- СПИСОК ЧАТОВ -->
			<?php if (!empty($data['chats'])): ?>
				<?php foreach ($data['chats'] as $i): ?>
					<a href="/chats/chat/<?=$i['userId'];?>/<?=$i['nic'];?><?php if(isset($_GET['search'])) echo "/?search=".$_GET['search'];?>" 
					class="sitebar_user 
					<?php if (isset($_GET['user']) && $data['chat']['chatId']==$i['chatId']): ?>
						<?php if ($data['contact']): ?>
							<?php echo "chat_item_active";?>
						<?php else: ?>
							<?php echo "chat_item_active_not_contact";?>
						<?php endif ?>
					<?php endif ?>
					"
					>
					<div class="sitebar_user_avatar" style="background: url('/_assets/img/<?=$i['avatar'];?>') no-repeat center center;background-size: cover;"></div>
					<div><?=$i['name'];?></span></div>
					<div><?=$i['nic'];?></div>
					<?php if (!empty($i['message']) && $i['message'] != ""): ?>
						<div class=""><?=$i['message_time'];?></div>
						<div class="sitebar_user_message <?php if($i['view']==0) echo "not_read";?>"><?=$i['message'];?></div>
					<?php endif ?>
					</a>
				<?php endforeach ?>
			<?php endif ?>
			<!-- СПИСОК ЧАТОВ -->

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