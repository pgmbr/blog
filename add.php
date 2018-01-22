<?php

$page_title = 'Add new';

include_once "_partials/header.php";

if ( isset( $_SESSION['form_data'] ) ) {
	extract( $_SESSION['form_data'] );
	unset( $_SESSION['form_data'] );
}
?>

    <section class="box">
	    <form action="<?= BASE_URL ?>/admin/add-item.php" method="post" class="post">
		    <header class="post-header">
			    <h1 class="box-heading">Add new post</h1>
		    </header>

		    <div class="form-group">
			    <input type="text" name="title" class="form-control" placeholder="title" value="<?= $title ?: '' ?>">
		    </div>

		    <div class="form-group">
			    <textarea name="text" rows="16" class="form-control"
			              placeholder="write your shit"><?= $text ?: '' ?></textarea>
		    </div>

		    <div class="form-group">
			    <input type="text" data-role="tagsinput" name="tagsinput" class="form-control" value="<?= $tags ?>" placeholder="write tags" >
		    </div>

		    <?php //include_once '_partials/edit-old-tags-form.php'?>


		    <div class="form-group">
			    <button type="submit" class="btn btn-primary">Add new post</button>
			    <span class="or">
				    or <a href="<?= BASE_URL ?>">cancel</a>
			    </span>
		    </div>
	    </form>
    </section>

<?php include_once "_partials/footer.php" ?>