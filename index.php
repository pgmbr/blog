<?php

require_once '_inc/config.php';

$routes = [
	// HOMEPAGE
	'/'       => [
		'GET' => 'home.php'             // show home page
	],
	// TAG
	'/tag'       => [
		'GET' => 'tag.php'              // show posts for tag
	],

	// TAG
	'/add_tag' => [
		'GET' => 'add_tag_form.php'              // show posts for tag
	],

	// TAG
	'/edit_tag' => [
		'GET' => 'edit_tag_form.php'              // show posts for tag
	],

	// TAG
	'/delete_tag' => [
		'GET' => 'delete_tag_form.php'              // show posts for tag
	],

	// TEST
	'/test' => [
		'GET' => '_inc/bower_components/bootstrap-tagsinput/examples/test.php'              // show posts for tag
	],

	// LOGIN
	'/login'   => [
		'GET'  => 'login.php',          // show login page
		'POST' => 'login.php'
	],
	// REGISTER
	'/register'   => [
		'GET'  => 'register.php',       // show registration new user
		'POST' => 'register.php'
	],
	// RESET
	'/reset' => [
		'GET'  => 'reset.php',          // show reset password page
		'POST' => 'reset.php'
	],
	// RESET
	'/resetpass' => [
		'GET'  => 'admin/resetpass.php',          //  reset password page
		'POST' => 'admin/resetpass.php'
	],
	// CHANGE PASSWORD
	'/setnewpass' => [
		'GET'  => 'admin/setnewpass.php',          //  change password page
		'POST' => 'admin/setnewpass.php'
	],
	// LOGOUT
	'/logout'   => [
		'GET' => 'logout.php'          // logout user
	],

	// USER
	'/user'   => [
		'GET' => 'user.php'
	],
	// POST
	'/post'   => [
		'GET' => 'post.php'   // add new post
	],
	// EDIT
	'/edit'   => [
		'GET' => 'edit.php'  // store new values
	],
	// DELETE
	'/delete' => [
		'GET' => 'delete.php'    // make the delete
	],
	// ADMINISTRATE USERS
	'/users' => [
		'GET' => 'users.php'
	],
	// ADMINISTRATE TAGS
	'/tags' => [
		'GET' => 'tags.php'
	],
	// EDIT USER by ADMINS
	'/editUser' => [
		'GET' => 'edit-user-form.php'           // make the edit user
	],
	// BAN USER
	'/banUser' => [
		'GET' => 'ban-user-form.php'            // make the ban user
	],
	// DELETE USER
	'/deleteUser' => [
		'GET' => 'delete-user-form.php'         // make the delete user
	]
];

$page   = segment( 1 );
$method = $_SERVER['REQUEST_METHOD'];
$public = [ 'login', 'register', 'reset', 'resetpass', 'setnewpass' ];

if (!logged_in() && !in_array($page, $public)) {
	redirect('/login');
}

if (!isset($routes["/$page"][$method])) {
	 show_404();
}

require $routes["/$page"][$method];
