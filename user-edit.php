<?php

// include
include_once "_partials/header.php";

if ( ! logged_in() ) {
	redirect( '/' );
}
// edituje admin
if ( ! empty( segment( 2 ) ) && is_int( segment( 2 ) ) ) {
	$uid  = segment( 2 );
	$uid  = filter_var( $uid, FILTER_VALIDATE_INT );
	$user = $auth->getUser( $uid );
} else {
	// edituje uzivatel svoj profil
	$user = $auth->getUser( $auth->getSessionUID( $_COOKIE['authID'] ) );
}

// kontrola prav
if ( $user['uid'] === $auth->getSessionUID( $_COOKIE['authID'] ) || is_admin() ) {

	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		var_dump( $_POST['role'] );

		if ( ! isset( $_POST['oldpassword'] ) ) {

			$uid             = filter_var( $user['uid'], FILTER_VALIDATE_INT );
			$username        = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
			$role            = filter_input( INPUT_POST, 'role', FILTER_SANITIZE_STRING );
			$email           = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
			$message_error   = [ ];
			$message_success = [ ];

			if ( isset( $_POST['role'] ) ) {
				$role = $auth->changeRole( $user['uid'], $role, $_POST['oldpassword'] );
				if ( $role['error'] ) {
					$message_error[] = $role['message'];
					unset( $role['message'] );
				} else {
					$message_success[] = $role['message'];
					unset( $role['message'] );
				}
			}

			if ( isset( $_POST['username'] ) ) {
				$username = $auth->changeUsername( $user['uid'], $username, $_POST['oldpassword'] );
				if ( $username['error'] ) {
					$message_error[] = $username['message'];
					unset( $username['message'] );
				} else {
					$message_success[] = $username['message'];
					unset( $username['message'] );
				}
			}

			if ( isset( $_POST['email'] ) ) {
				$auth->changeEmail( $user['uid'], $_POST['email'], $_POST['oldpassword'] );
				if ( $username['error'] ) {
					$message_error[] = $username['message'];
					unset( $username['message'] );
				} else {
					$message_success[] = $username['message'];
					unset( $username['message'] );
				}
			}

			if ( isset( $_POST['oldpassword'] ) && isset( $_POST['newpassword'] ) && isset( $_POST['repeatpassword'] ) ) {
				$auth->changePassword( $user['uid'], $_POST['oldpassword'], $_POST['newpassword'],
					$_POST['repeatpassword'] );
				if ( $username['error'] ) {
					$message_error[] = $username['message'];
					unset( $username['message'] );
				} else {
					$message_success[] = $username['message'];
					unset( $username['message'] );
				}
			}


			if ( ! empty( $message_error ) && is_array( $message_error ) ) {
				foreach ( $message_error as $message ) {
					flash()->error( $message );
				}
			}

			if ( ! empty( $message_success ) && is_array( $message_success ) ) {
				foreach ( $message_success as $message ) {
					flash()->success( $message );
				}
			}
		} else {
			flash()->error( 'type the current password for edit' );
		}

	}
	//redirect('/');

} else {
	flash()->error( "bye asshole, you don't permissions" );
	redirect( '/' );
}

?>
<section class="box post-list">
	<h1 class="box-heading text-muted">Edit user</h1>
	<form action="" method="post" class="post">

		<?php if ( $user['role'] === 'admin' ): ?>
			<div class="form-group checkbox checkbox-inline">
				<label class="btn btn-primary">
					<input type="radio" name="role" value="user" id="user" autocomplete="off"> user
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="role" value="mod" id="mod" autocomplete="off"> moderator
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="role" value="admin" id="admin" autocomplete="off"> administrator
				</label>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="">Username</label>
			<input type="text" name="username" class="form-control" placeholder="username"
			       value="<?= $user['username'] ?: '' ?>">
		</div>

		<div class="form-group">
			<label for="">Email</label>
			<input type="text" name="email" class="form-control" placeholder="email"
			       value="<?= $user['email'] ?: '' ?>">
		</div>

		<div class="form-group">
			<label for="">New password</label>
			<input type="password" name="newpassword" class="form-control" placeholder="newpassword" value="">
		</div>
		<div class="form-group">
			<label for="">New password again</label>
			<input type="password" name="repeatpassword" class="form-control" placeholder="repeatpassword" value="">
		</div>
		<div class="form-group">
			<label for="">Enter current password for edit</label>
			<input type="password" name="oldpassword" class="form-control" placeholder="oldpassword" value="">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Edit user</button>
		</div>
	</form>

</section>

<?php include_once "_partials/footer.php" ?>
