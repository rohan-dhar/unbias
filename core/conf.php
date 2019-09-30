<?php 
	
	/* 
		TODO:
		Sets up basic settings and object and include core files to be autoloaded
	*/

	// General Settins	
	define('APP_NAME', 'unBias');
	define('ROOT', substr(__DIR__, 0, strlen(__DIR__) - 4));// Used to include PHP code
	define("HTML_ROOT", "http://localhost/byld"); // Used to include front-end files


	// Database Settings
	define('DB_NAME', 'DBNAME');
	define('DB_HOST', 'HOST');
	define('DB_USER', 'USERNAME');
	define('DB_PASS', 'PASS');


	// Error reporting settings	
	define('RUN_STATE', 'DEV'); // Can be DEV or PROD 
	error_reporting(E_ALL);

	// Inlcuding autoload/* files
	require 'autoload/db.php';

	function initSession($opt = false){
		session_start();
		session_regenerate_id();
		if($opt === false){
			session_write_close();
		}
	}

	$interests = [
		"Economy", //0
		"Religion", //1
		"Environment", //2
		"Rular Development", //3
		"Urban Development", //4
		"Gender Equality", //5
		"Social Welfare", //6
		"Education" //7
	];


?>