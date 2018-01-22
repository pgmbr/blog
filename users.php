<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 10.1.18
 * Time: 14:16
 */

	try {
		$results = get_users();
	}
	catch (PDOException $e) {
		// also handle errors maybe
		$results = [];
	}



include_once "_partials/header.php";
?>
	<section class="box post-list">
		<h1 class="box-heading text-muted">Admin users</h1>
		<?php if (count($results)) : foreach ($results as $user) :  ?>
			<article id="user-<?= $user->id ?>" class="post">
				<h3 class="post-header">
					<a href="<?= $user->link ?>">
						<?= $user->username ?>
					</a>
				</h3>
				<? if ( is_admin() ): ?>
					<div class="pull-right">
						<a href="<?= get_edit_user_link( $user ) ?>" class="btn btn-xs edit-link">edit</a>
						<!--						<a href="-->
						<? //= get_ban_user_link( $user ) ?><!--" class="btn btn-xs edit-link">ban</a>-->
						<a href="<?= get_delete_user_link( $user ) ?>" class="btn btn-xs edit-link">&times;</a>
					</div>
				<? endif; ?>
				<ul class="user-list">
					<li>
						rola: &nbsp;
						<?= $user->role ?>
					</li>
					<li>
						mail: &nbsp;
						<a href="<?= $user->email ?>"><?= $user->email ?></a>
					</li>
					<li>
						založený: &nbsp;
						<time datetime="<?= $user->date ?>">
							<small><?= $user->time ?></small>
						</time>
					</li>
				</ul>
				<div class="post-content">
				</div>
				<hr>
			</article>
		<?php endforeach; else: ?>
			<p>we got nothing :(</p>
		<?php endif; ?>
	</section>
<?php include_once "_partials/footer.php" ?>