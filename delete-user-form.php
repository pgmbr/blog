<?php


try {
	$post = get_post( segment( 2 ) );

	if ( ! post_permition( $post ) ) {
		flash()->info( 'You must by author' );
		redirect( '/' );
	}
} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}

if ( ! $post ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = 'Delete / ' . $post->title;

include_once "_partials/header.php";
?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/delete-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Sure you wanna do this?
				</h1>
			</header>

			<blockquote class="form-group">
				<h3>&ldquo;<?= $post->title ?>&rdquo;</h3>
				<p class="teaser"><?= $post->teaser ?></p>
			</blockquote>

			<div class="form-group">
				<input name="post_id" value="<?= $post->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Delete post</button>
			    <span class="or">
				    or <a href="<?= get_post_link( $post ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>