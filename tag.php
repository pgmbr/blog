<?php
	$results = get_posts();


include_once "_partials/header.php";
?>
<section class="box post-list">
	<h1 class="box-heading text-muted">This is a blog, bitch</h1>
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
				
				<?php if ($post->tags) : ?>
					<p class="tags">
						<?php foreach ($post->tag_links as $tag => $tag_link) : ?>
							<a href="<?= $tag_link ?>" class="btn btn-warning btn-xs"><small><?= $tag ?></small></a>
						<?php endforeach; ?>
					</p>
				<?php endif; ?>

			</header>
			<div class="post-content">
				<p>
					<?= $post->teaser ?>
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