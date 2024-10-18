<form class="sitebar-search" method="get" action="/<?=Route::$page;?>/index/">
	<input type="search" name="search" placeholder="<?=$data['placeholder'];?>" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>">
</form>