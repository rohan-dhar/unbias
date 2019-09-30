<?php 	

	/*
		TODO:
		Establishes a MySQL Database connection using settings defined in conf
	*/

	global $db;

	try{
		$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset:utf8', DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e) {
	   die ("Whoops! A fatal error occured. Try again later. (DB_REFUSED)");
	}

	date_default_timezone_set("Asia/Kolkata");
	$db->exec("SET time_zone='+5:30'");
?>