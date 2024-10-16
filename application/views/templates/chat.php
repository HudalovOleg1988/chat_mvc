<?php if (isset($_GET['user']) && !empty($data['user'])): ?>
	<?php if ($data['user']['userId'] != $_SESSION['user_id']): ?>
	<div class="content">

		<!-- ПОРТФОЛИО -->
		<div class="content_portfolio">
			<!-- АВАТАР -->
			<div class="content_portfolio_avatar" style="background: url('/_assets/img/<?=$data['user']['avatar'];?>') no-repeat center center; background-size: cover;"></div>
			<!-- АВАТАР -->
			<!-- ИМЯ ПОЧТА -->
			<div><?=$data['user']['name'];?> | <?=$data['user']['email'];?></div>
			<!-- ИМЯ ПОЧТА -->

			<!-- МЕНЮ КОНТАКТА -->
			<?php if (in_array($_GET['user'],$_SESSION['contacts'])): ?>
				<!-- добавить в контакты -->
				<a href="/<?=Route::$page;?>/delete_contact/?delete_contact=<?=$data['user']['userId'];?><?php if(isset($_GET['search'])) echo '&search='.$_GET['search'];?>">delete contact</a>
				<!-- добавить в контакты -->
				<!-- удалить чат -->
				<?php if (!empty($data['chat'])): ?>
					<a href="/<?=Route::$page;?>/drop_chat_warning/?drop_chat_warning=<?=$data['user']['userId'];?><?php if(isset($_GET['search'])) echo '&search='.$_GET['search'];?>">drop</a>
				<?php endif ?>
				<!-- удалить чат -->
				<!-- очистить чат -->
				<?php if (!empty($this->data['messages'])): ?>
					<a href="/<?=Route::$page;?>/clean_messages_warning/?clean_messages_warning=<?=$data['user']['userId'];?><?php if(isset($_GET['search'])) echo '&search='.$_GET['search'];?>">clean</a>
				<?php endif ?>
				<!-- очистить чат -->

			<?php else: ?>
				<!-- ДОБАВИТЬ В КОНТАКТЫ -->
				<a href="/<?=Route::$page;?>/add_contact/?add_contact=<?=$data['user']['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="content-portfolio-add-contact">add contact</a>	
				<!-- ДОБАВИТЬ В КОНТАКТЫ -->
			<?php endif ?>
			<!-- МЕНЮ КОНТАКТА -->


		</div>
		<!-- ПОРТФОЛИО -->

		<?php if (in_array($_GET['user'],$_SESSION['contacts'])): ?>
			<!-- ФОРМА ОТПРАВКИ СООБЩЕНИЯ -->
			<form action="/<?=Route::$page;?>/send_message" method="post" class="content_send">
				<input type="hidden" name="search" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>">
				<input type="hidden" name="user" value="<?=$data['user']['userId'];?>">
				<input type="text" name="message" placeholder="write youre message...">
				<input type="submit" value="send">
			</form>
			<!-- ФОРМА ОТПРАВКИ СООБЩЕНИЯ -->

			<!-- ЧАТ -->
			<?php if (!empty($data['messages'])): ?>
				<?php foreach ($data['messages'] as $message): ?>
					<?php if ($message['user_id'] == $_SESSION['user_id']): ?>

						<!-- БЛОК СООБЩЕНИЯ ПОЛЬЗОВАТЕЛЯ -->
						<div href="" class="content_chat content_chat_user">
							<!-- аватар -->
							<div class="content_chat_avatar" style="background: url('/avatars/<?=$_SESSION['avatar'];?>') no-repeat center center; background-size: cover;"></div>
							<!-- аватар -->
							<!-- имя время -->
							<div class="content_chat_name">me <span><?=$message['messagetime'];?></span></div>
							<!-- имя время -->
							<!-- ник -->
							<div class="content_chat_name"><?=$_SESSION['nic'];?></div>
							<!-- ник -->
							<!-- сообщение -->
							<div class=""><?=$message['message'];?></div>
							<!-- сообщение -->
						</div>
						<!-- БЛОК СООБЩЕНИЯ ПОЛЬЗОВАТЕЛЯ -->

					<?php else: ?>

						<!-- БЛОК СООБЩЕНИЯ ОПОНЕНТА -->
						<div href="" class="content_chat">
							<!-- аватар -->
							<div class="content_chat_avatar" style="background: url('/avatars/<?=$data['user']['avatar'];?>') no-repeat center center; background-size: cover;"></div>
							<!-- аватар -->
							<!-- имя время -->
							<div class="content_chat_name"><?=$data['user']['name'];?> <span><?=$message['messagetime'];?></span></div>
							<!-- имя время -->
							<!-- ник -->
							<div class="content_chat_name"><?=$data['user']['nic'];?></div>
							<!-- ник -->
							<!-- сообщение -->
							<div class="<?php echo ($message['view']==0) ? "content_chat_message_new" : ""; ?>"><?=$message['message'];?></div>
							<!-- сообщение -->
						</div>
						<!-- БЛОК СООБЩЕНИЯ ОПОНЕНТА -->
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>
			<!-- ЧАТ -->
		<?php endif ?>

	</div>	
	<?php else: ?>
		<div class="content"><h1>Youre account</h1></div>
	<?php endif ?>
<?php endif ?>