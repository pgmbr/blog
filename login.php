<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */
require_once '_inc/config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	$email    = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
	$remember = filter_input( INPUT_POST, 'rememberMe', FILTER_SANITIZE_STRING );
	$password = $_POST['password'];

	$login = $auth->login( $email, $password, isset( $remember ) );

	if ( $login['error'] ) {
		flash()->error( $login['message'] );
	} else {
		do_login( $login );

		flash()->success( 'You are logged' );
		redirect( '/' );
	}

}


include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">
	<h2 class="box-auth-heading">
		Login
	</h2>

	<input type="text" name="email" value="" placeholder="Email Address" class="form-control" required>
	<input type="password" name="password" placeholder="Password" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
	<label class="checkbox">
		<input type="checkbox" name="rememberMe" id="rememberMe" value="remember-me" checked>
		Remember me
	</label>

	<p class="alt-action text-center">
		Not registered?<br>
		<a href="<?= BASE_URL ?>/register">Register</a>
	</p>
	<p class="alt-action text-center">
		Forgot your password?<br>
		<a href="<?= BASE_URL ?>/reset">Reset password</a>
	</p>
</form>
