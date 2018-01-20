<?php


try {
	$tag =  segment( 2 );

} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}
if ( ! $tag ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = 'Edit / ' . $tag;
$tag_id = get_tag_id($tag);

include_once "_partials/header.php";
?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/edit-tag.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Edit &ldquo; <?= plain( $tag ) ?> &rdquo;
				</h1>
			</header>

			<div class="form-group">
				<input type="text" name="tag" class="form-control" value="<?= plain($tag) ?>" placeholder="tag">
			</div>

			

			<div class="form-group">
				<input name="tag_id" value="<?= $tag_id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Edit tag</button>
			    <span class="or">
				    or <a href="<?= get_tag_link( $tag ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>