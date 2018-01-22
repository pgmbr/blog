<?php


	try {
		$post = get_post( segment( 2 ), false );

	} catch ( PDOException $e ) {
		// also handle errors maybe
		$results = [ ];
	}
	if ( ! $post ) {
		flash()->error( "doesn't exist :(" );
		redirect( '/' );


	}

	$tags = get_post($post->id)->strtags;

	var_dump( $tags );


	$page_title = 'Edit / ' . $post->title;

	include_once "_partials/header.php";

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/edit-item.php" method="post" class="post" id="edit-form">
			<header class="post-header">
				<h1 class="box-heading">
					Edit &ldquo; <?= plain( $post->title ) ?> &rdquo;
				</h1>
			</header>

			<div class="form-group">
				<input type="text" name="title" class="form-control" value="<?= $post->title ?>" placeholder="title">
			</div>

			<div class="form-group">
				<textarea name="text" rows="16" class="form-control"
				          placeholder="write your shit"><?= $post->text ?></textarea>
			</div>

			<div class="form-group">
				<input type="text" data-role="tagsinput" name="tagsinput" class="form-control" value="<?= $tags ?>" placeholder="write tags" >
			</div>

		<?php //include_once '_partials/edit-old-tags-form.php'?>

			<div class="form-group">
				<input name="post_id" value="<?= $post->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Edit post</button>
			    <span class="or">
				    or <a href="<?= get_post_link( $post ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>