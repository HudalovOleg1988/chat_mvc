<?php

	session_start();

	include $_SERVER['DOCUMENT_ROOT']."/application/db.php";
	include $_SERVER['DOCUMENT_ROOT']."/application/controllers/controller.php";
	
	include $_SERVER['DOCUMENT_ROOT']."/application/route.php";
	Route::start();

?>
