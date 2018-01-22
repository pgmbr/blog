<?php


try {
	$tag = segment_tag_decode( 2 );

} catch ( PDOException $e ) {
	// also handle errors maybe
	$results = [ ];
}
if ( ! $tag ) {
	flash()->error( "doesn't exist :(" );
	redirect( '/' );
}

$page_title = 'Delete / ' . $tag;
$tag_id     = get_tag_id( $tag );
var_dump( $tag );
var_dump( $tag_id );

include_once "_partials/header.php";
?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/delete-tag.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Delete &ldquo; <?= plain( $tag ) ?> &rdquo;
				</h1>
			</header>

			<div class="form-group">
				<input name="tag_id" value="<?= $tag_id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Delete tag</button>
			    <span class="or">
				    or <a href="<?= get_tag_link( $tag ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>