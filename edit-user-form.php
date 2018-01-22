<?php

try {
	$user = $auth->getUser( segment( 2 ) );

} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}
if ( ! $user ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = 'Edit / ' . $user['username'];

include_once "_partials/header.php";
?>

<section class="box post-list">
	<h1 class="box-heading text-muted">Edit user <span><?= $user['username'] ?></span></h1>
	<form action="<?= BASE_URL ?>/admin/edit-user.php" method="post" class="post">

		<?php if ( is_admin() ): ?>
			<div class="form-group checkbox checkbox-inline">

				<label class="btn btn-primary">
					<input type="radio" name="role" value="user" id="user"
					       autocomplete="off" <?= ( $user['role'] === 'user' ) ? 'checked' : '' ?>> user
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="role" value="mod" id="mod"
					       autocomplete="off" <?= ( $user['role'] === 'mod' ) ? 'checked' : '' ?>> moderator
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="role" value="admin" id="admin"
					       autocomplete="off" <?= ( $user['role'] === 'admin' ) ? 'checked' : '' ?>> administrator
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
			<input name="user_id" value="<?= $user['uid'] ?>" type="hidden">
			<button type="submit" class="btn btn-primary">Edit user</button>
		</div>
	</form>

</section>

<?php include_once "_partials/footer.php" ?>
