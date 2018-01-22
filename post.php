<?php

$id = segment( 2 );
// add new post form
if ( $id === 'new' ) {
	include_once 'add.php';
	die();
}

try {
	$post = get_post();
} catch ( PDOException $e ) {
	$post = false;
}

if ( ! $post ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = $post->title;

include_once "_partials/header.php";
?>
<section class="box post-list">
	<? if ( can_edit( $post ) ): ?>
		<div class="pull-right">
			<h3>Edit post</h3>
			<a href="<?= get_edit_link( $post ) ?>" class="btn btn-xs edit-link">edit</a>
			<a href="<?= get_delete_link( $post ) ?>" class="btn btn-xs edit-link">&times;</a>

		</div>
	<? endif; ?>
	<h1 class="box-heading text-muted">This is a blog, bitch</h1>

	<article id="post-<?= $post->id ?>" class="post">
		<header class="post-header">
			<h2 class="box-heading">
				<a href="<?= $post->link ?>"><?= $post->title ?></a>

				<br>
				<time datetime="<?= $post->date ?>">
					<small><?= $post->time ?></small>
				</time>

			</h2>

		</header>
		<div class="post-content">
			<p>
				<?= $post->text ?>
			</p>
			<p class="written-by small">
				<small>written by <a href="<?= $post->user_link ?>"><?= $post->username ?></a></small>
			</p>
		</div>
		<div class="footer post-footer">
			<a class="read-more" href="<?= BASE_URL ?>">
				back
			</a>
		</div>
	</article>

	<footer class="post-footer">
		<?php include '_partials/tags.php' ?>
	</footer>


</section>

<?php include_once "_partials/footer.php" ?>

