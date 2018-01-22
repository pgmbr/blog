<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */
require_once '_inc/config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	$username        = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
	$email           = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
	$password        = $_POST['password'];
	$password_repeat = $_POST['repeat'];

	$register = $auth->register( $username, $email, $password, $password_repeat );

	if ( $register['error'] ) {
		flash()->error( $register['message'] );
	} else {
		flash()->success( 'Vitaj' );
		redirect( '/login' );
	}

}

include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">
	<h2 class="box-auth-heading">
		Register
	</h2>

	<input type="text" name="username" value="<?= $_POST['username'] ?>" placeholder="Name" class="form-control"
	       required>
	<input type="text" name="email" value="<?= $_POST['email'] ?>" placeholder="Email Address" class="form-control"
	       required>
	<input type="password" name="password" placeholder="Password" class="form-control" required>
	<input type="password" name="repeat" placeholder="Password again, DO IT" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>

	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
	</p>
</form>
