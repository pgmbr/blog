<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */
require_once '_inc/config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' || segment( 2 ) ) {

	if ( segment( 2 ) ) {
		$key = segment( 2 );
		$key = filter_var( $key, FILTER_SANITIZE_STRING );
	} else {
		$key = filter_input( INPUT_POST, 'key', FILTER_SANITIZE_STRING );
	}

	$reset = $auth->getRequest( $key, 'reset' );

	if ( $reset['error'] ) {
		flash()->error( $reset['message'] );
	} else {
		$_SESSION['reset'] = $reset;
		flash()->success( $reset['message'] );
		redirect( '/setnewpass' );
	}

}


include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">
	<h2 class="box-auth-heading">
		Reset password
	</h2>

	<input type="text" name="key" value="<?= $key ?: '' ?>" placeholder="key" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Reset password</button>


	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/register">Register</a>
	</p>
	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/login">login</a>
	</p>
</form>
