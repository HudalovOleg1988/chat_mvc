<div class="sitebar-nav">
	<a href="/chats" <?php if(Route::$page=="chats") echo "class='active'";?>>
		chats 
		<?php echo (!empty($data['messageCount'])) ? COUNT($data['messageCount']) : '0';?>
	</a>
	<a href="/search" <?php if(Route::$page=="search") echo "class='active'";?>>search</a>
	<a href="/contact" <?php if(Route::$page=="contact") echo "class='active'";?>>contact</a>
	<a href="/settings" <?php if(Route::$page=="settings") echo "class='active'";?>>settings</a>
	<a href="/logout">logout</a>
</div>