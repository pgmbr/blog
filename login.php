<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 6.1.18
 * Time: 22:26
 */

include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">
	<h2 class="box-auth-heading">
		Register, you dumbass
	</h2>

	<input type="text" name="email" value="" placeholder="Email Address" class="form-control" required>
	<input type="password" name="password" placeholder="Password" class="form-control" required>
	<input type="password" name="repeat" placeholder="Password again, DO IT" class="form-control" required>
	<button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>

	<p class="alt-action text-center">
		or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
	</p>
</form>
