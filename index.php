<?php

require_once '_inc/config.php';

$routes = [
	// HOMEPAGE
	'/'       => [
		'GET' => 'home.php'
	],
	// TAG
	'/tag'       => [
		'GET' => 'tag.php'              // show posts for tag
	],

	// LOGIN
	'/login'   => [
		'GET'  => 'login.php',
		'POST' => 'login.php'
	],
	// REGISTER
	'/register'   => [
		'GET'  => 'register.php',
		'POST' => 'register.php'
	],
	// LOGOUT
	'/logout'   => [
		'GET'  => 'logout.php'
	],

	// USER
	'/user'   => [
		'GET'  => 'user.php',           // show user post
		'POST' => '_inc/post_add.php'   // add new post
	],
	// POST
	'/post'   => [
		'GET'  => 'post.php',           // show post
		'POST' => '_inc/post_add.php'   // add new post
	],
	// EDIT
	'/edit'   => [
		'GET'  => 'edit.php',           // edit form
		'POST' => '_inc/post_edit.php'  // store new values
	],
	// DELETE
	'/delete' => [
		'GET'  => 'delete.php',              // delete form
		'POST' => '_inc/post_delete.php'    // make the delete
	],
	// MODERATE POSTS
	'/mod'   => [
		'GET'  => 'mod.php',
		'POST' => 'login.php'
	],
	// ADMIN USERS
	'/admin'   => [
		'GET'  => 'admin.php',
		'POST' => 'users.php'
	]
];

$page = segment(1);
$method = $_SERVER['REQUEST_METHOD'];
$public = ['login', 'register'];

if (!logged_in() && !in_array($page, $public)) {
	redirect('/login');
}

if (!isset($routes["/$page"][$method])) {
	 show_404();
}

require $routes["/$page"][$method];
