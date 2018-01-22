<?php

// show all errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
// error_reporting(-1);
error_reporting( E_ALL & ~E_NOTICE );

require_once 'vendor/autoload.php';
// start session
if (!session_id()) @session_start();

// EOL
define('NL', "\n");
define('TAB', "\t");

// constant & settings
define( 'BASE_URL', 'http://localhost:8888/blog' );
define( 'APP_PATH', realpath( __DIR__ . '/../' ) );

// configuration
$config_blog = [

	'db' => [
		'type'     => 'mysql',
		'name'     => 'miniblog',
		'server'   => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset'  => 'utf8'
	]
];

// Connect to DB
$db = new PDO(
	"{$config_blog['db']['type']}:host={$config_blog['db']['server']};
	dbname={$config_blog['db']['name']};charset={$config_blog['db']['charset']}",
	$config_blog['db']['username'], $config_blog['db']['password']
);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );


require_once 'functions-general.php';
require_once 'functions-auth.php';
require_once 'functions-string.php';
require_once 'functions-post.php';
require_once 'functions-tag.php';


require_once "vendor/phpauth/phpauth/Config.php";
require_once "vendor/phpauth/phpauth/Auth.php";

$dbh    = $db;
$config = new PHPAuth\Config( $dbh );
$auth   = new PHPAuth\Auth( $dbh, $config, 'sk_SK' );
