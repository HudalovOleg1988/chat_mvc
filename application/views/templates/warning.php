<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ СООБЩЕНИЙ ЧАТА -->
<?php if (isset($_GET['clean_messages_warning'])): ?>
	<div class="clean_warning_block">
		<div class="clean_warning">
			<div class="clean_warning_avatar" style="background: url('/assets/css/img/<?=$this->data['user']['avatar'];?>') no-repeat center center;background-size: cover;"></div>
			<div class="clean_warning_name"><?=$this->data['user']['name'];?></div>

			<a href="/<?=Route::$page;?>/chat/?user=<?=$this->data['user']['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="clean_warning_cancel">Cancel</a>
			<a href="/<?=Route::$page;?>/clean_messages/?clean_messages=<?=$this->data['user']['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="clean_warning_clean">Clean chat</a>
		</div>
	</div>
<?php endif ?>
<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ СООБЩЕНИЙ ЧАТА -->

<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ ЧАТА -->
<?php if (isset($_GET['drop_chat_warning'])): ?>
	<div class="clean_warning_block">
		<div class="clean_warning">
			<div class="clean_warning_avatar" style="background: url('/avatars/<?=$this->data['user']['avatar'];?>') no-repeat center center;background-size: cover;"></div>
			<div class="clean_warning_name"><?=$this->data['user']['name'];?></div>
			<a href="/<?=Route::$page;?>/chat/?user=<?=$this->data['user']['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="clean_warning_cancel">Cancel</a>
			<a href="/<?=Route::$page;?>/drop_chat/?drop_chat=<?=$this->data['user']['userId'];?><?php if(isset($_GET['search'])) echo "&search=".$_GET['search'];?>" class="clean_warning_clean">Drop chat</a>
		</div>
	</div>
<?php endif ?>
<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ ЧАТА -->