<?php


try {
	$user = get_user( segment( 2 ) );

	if ( ! can_edit( $user ) ) {
		flash()->info( 'You must by author' );
		redirect( '/' );
	}
} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}

if ( ! $user ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = 'Blocked / ' . $user->username;

include_once "_partials/header.php";
?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/ban-user.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Sure you wanna do this?
				</h1>
			</header>

			<blockquote class="form-group">
				<h3>&ldquo;<?= $user->username ?>&rdquo;</h3>
			</blockquote>

			<div class="form-group">
				<input name="user_id" value="<?= $user->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Blocked user</button>
			    <span class="or">
				    or <a href="<?= get_user_link( $user ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>