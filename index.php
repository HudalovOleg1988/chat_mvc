<?php

	session_start();

	// unset($_SESSION['login']);
	// unset($_SESSION['name']);
	// unset($_SESSION['email']);
	// unset($_SESSION['nic']);
	// unset($_SESSION['user_id']);
	// unset($_SESSION['avatar']);
	
	include $_SERVER['DOCUMENT_ROOT']."/application/db.php";
	include $_SERVER['DOCUMENT_ROOT']."/application/controllers/controller.php";
	
	include $_SERVER['DOCUMENT_ROOT']."/application/route.php";
	Route::start();

?>