<?php


$page_title = 'Add tag';

include_once "_partials/header.php";
?>

	<section class="box">
		<form action="<?= BASE_URL ?>/admin/add-tag.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Add tag
				</h1>
			</header>

			<div class="form-group">
				<input type="text" name="tag" class="form-control" value="" placeholder="tag">
			</div>


			<div class="form-group">
				<button type="submit" class="btn btn-primary">Add tag</button>
			    <span class="or">
				    or <a href="<?= get_tag_link( $tag ) ?>">cancel</a>
			    </span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>