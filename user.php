<?php
$user = get_user( segment( 2 ) );

try {
	$results = get_posts_by_user( $user->uid );
} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}

// var_dump( $user->id );
// var_dump( $auth->getSessionUID( $_COOKIE[ $config->cookie_name ] ) );


include_once "_partials/header.php";
?>
<section class="box post-list">
	<h1 class="box-heading text-muted">
		<small>by</small> <?= $user->username ?>
		<? if ( is_admin() || ($auth->getSessionUID( $_COOKIE[ $config->cookie_name ] ) === $user->id) ): ?>
			<div class="pull-right">
				<h3>Edit user</h3>
				<a href="<?= get_edit_user_link( $user ) ?>" class="btn btn-xs edit-link">edit</a>
				<!--				<a href="-->
				<? //= get_ban_user_link( $user ) ?><!--" class="btn btn-xs edit-link">ban</a>-->
				<a href="<?= get_delete_user_link( $user ) ?>" class="btn btn-xs edit-link">&times;</a>
			</div>
		<? endif; ?>
	</h1>


	<?php if (count($results)) : foreach ($results as $post) :  ?>
		<article id="post-<?= $post->id ?>" class="post">
			<header class="post-header">
				<h2>
					<a href="<?= $post->link ?>">
						<?= $post->title ?>
					</a>
					<br>
					<time datetime="<?= $post->date ?>">
						<small> / <?= $post->time ?></small>
					</time>
				</h2>

				<?php include '_partials/tags.php'?>

			</header>
			<div class="post-content">
				<p>
					<?= $post->teaser ?>
				</p>
				<p class="written-by small">
					<small>written by <a href="<?= $post->user_link ?>"><?= $post->username ?></a></small>
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