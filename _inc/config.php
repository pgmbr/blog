<?php

// show all errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

// start session
if (!session_id()) @session_start();


// EOL
define('NL', "\n");
define('TAB', "\t");
// global variables

$config = [
	'base_url' => 'http://localhost:8888/todoapp',
	'database' => [
		'database_type' => 'mysql',
		'database_name' => 'todoapp',
		'server'        => 'localhost:8889',
		'username'      => 'todoapp',
		'password'      => 'todoapp',
		'charset'       => 'utf8'
	]

]



// require stuff
require_once 'vendor/autoload.php';
require_once 'functions.php';
