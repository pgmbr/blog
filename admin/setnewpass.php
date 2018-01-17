<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */
require_once '_inc/config.php';

var_dump( $_SESSION );
if ($_SESSION['reset']) {
	$uid = $_SESSION['reset']['uid'];
	$uid = filter_var($uid, FILTER_VALIDATE_INT);
	unset($_SESION['reset']);
} else {
	flash()->error('not found data');
	redirect('/');
}
var_dump($post_reset);
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	
	die();
	$post_reset = $auth->setNewPassword($uid, $newpassword, $repeatnewpassword);
	
	
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
		Set new password
	</h2>

	<input type="text" name="newpassword" value="" placeholder="Password" class="form-control" required>
	<input type="text" name="repeatnewpassword" value="" placeholder="Password" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Set new password</button>


	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/register">Register</a>
	</p>
	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/login">login</a>
	</p>
</form>
