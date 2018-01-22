<?php
$tag = urldecode( segment( 2 ) );
$tag = plain( $tag );

$tag_id = get_tag_id( $tag );

try {
	$results = get_posts_by_tag( $tag );
} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}
include_once "_partials/header.php";
?>
<section class="box post-list">
	<? if ( is_admin() || is_mod() ): ?>
		<div class="pull-right">
			<h3>Edit tag</h3>
			<a href="<?= get_tag_add_link() ?>" class="btn btn-xs edit-link">add</a>
			<a href="<?= get_tag_edit_link( $tag ) ?>" class="btn btn-xs edit-link">edit</a>
			<a href="<?= get_tag_delete_link( $tag ) ?>" class="btn btn-xs edit-link">&times;</a>
		</div>
	<? endif; ?>
	<h1 class="box-heading text-muted">&ldquo; <?= $tag ?> &rdquo;</h1>
	<?php if (count($results)) : foreach ($results as $post) :  ?>
		<article id="post-<?= $post->id ?>" class="post">
			<header class="post-header">
				<h2>
					<a href="<?= $post->link ?>">
						<?= $post->title ?>
					</a>
					<time datetime="<?= $post->date ?>">
						<small> / <?= $post->time ?></small>
					</time>
				</h2>
				<?php include '_partials/tags.php' ?>

			</header>
			<div class="post-content">
				<p>
					<?= $post->teaser ?>
				</p>
				<p class="written-by small">
					<small>written by <a href="<?= $post->user_link ?>"><?= $post->email ?></a></small>
				</p>
			</div>
			<div class="footer post-footer">
				<a class="read-more" href="<?= $post->link ?>">
					read more
				</a>
			</div>
		</article>
	<?php endforeach; else: ?>
		<p>we got nothing :(</p>
	<?php endif; ?>
</section>
<?php include_once "_partials/footer.php" ?>