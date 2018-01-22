<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 10.1.18
 * Time: 14:16
 */

	try {
		$results = get_tags();
	}
	catch (PDOException $e) {
		// also handle errors maybe
		$results = [];
	}

include_once "_partials/header.php";
?>
	<section class="box post-list">
		<h1 class="box-heading text-muted">List all tags</h1>
		<?php if (count($results)) : foreach ($results as $tag) :  ?>
			<article id="tag-<?= $tag->id ?>" class="post">
				<h3 class="post-header">
					<a href="<?= $tag->link ?>">
						<?= $tag->name ?>
					</a>
					<? if ( is_admin() || is_mod() ): ?>
						<div class="pull-right">
							<a href="<?= $tag->editlink ?>" class="btn btn-xs edit-link">edit</a>
							<a href="<?= $tag->deletelink ?>" class="btn btn-xs edit-link">&times;</a>
						</div>
					<? endif; ?>
				</h3>

				<hr>
			</article>
		<?php endforeach; else: ?>
			<p>we got nothing :(</p>
		<?php endif; ?>
	</section>
<?php include_once "_partials/footer.php" ?>