<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */
require_once '_inc/config.php';


if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
	$reset = $auth->requestReset( $email );

	if ( $reset['error'] ) {
		flash()->error( $reset['message'] );
	} else {
		flash()->success( $reset['message'] );
		redirect( '/' );
	}

}


include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">
	<h2 class="box-auth-heading">
		Reset password
	</h2>

	<input type="text" name="email" value="" placeholder="Email Address" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Reset password</button>


	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/register">Register</a>
	</p>
	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/login">login</a>
	</p>
</form>
