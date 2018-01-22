<!DOCTYPE html>
<html>
<head lang="sk">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= isset( $page_title ) ? "$page_title / " : '' ?>this is a blog</title>

<!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">-->
<!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
	<link rel="stylesheet" href="../assets/css/bootstrap-tagsinput.css">
<!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/themes/github.css">-->
	<link rel="stylesheet" href="../assets/css/app.css">

	<link rel="stylesheet" href="<?= asset( 'css/bootstrap.min.css' ) ?>">
	<link rel="stylesheet" href="<?= asset( 'css/main.css' ) ?>">

	<script>
		var baseURL = '<?= BASE_URL ?>';
	</script>
</head>
<body class="<?= segment( 1 ) ? plain( segment( 1 ) ) : 'home' ?>">

<? // var_dump( $auth->getUser($auth->getSessionUID( $_COOKIE[ $config->cookie_name ]) ) ); ?>


<header class="container">
	<?= flash()->display() ?>
	<!--navigation all that-->
	<?php if ( logged_in() ): $logged_in = get_user() ?>
		<div class="navigation btn-group btn-group-sm pull-left">
			<a href="<?= BASE_URL ?>" class="btn btn-default"> all posts </a>
			<a href="<?= BASE_URL ?>/user/<?= $logged_in->uid ?>" class="btn btn-default"> my posts </a>
			<a href="<?= BASE_URL ?>/post/new" class="btn btn-default"> add new post </a>
			<?php if ( is_admin() || is_mod() ) : ?>
				<a href="<?= get_tag_add_link() ?>" class="btn btn-default">Add new tag</a>
			<?php endif; ?>
			<a href="<?= BASE_URL ?>/tags" class="btn btn-default"> All tags </a>
		</div>

		<div class="navigation btn-group btn-group-sm pull-right">

			<a href="<?= get_user_link($auth->getUser($auth->getSessionUID( $_COOKIE[ $config->cookie_name ] ))) ?>"
			   class="btn btn-default user"> <?= get_role() . ' ' . plain( $logged_in->username ) ?> </a>
			<a href="<?= BASE_URL ?>/logout" class="btn btn-default logout"> logout </a>
		</div>
	<?php endif; ?>
</header>

<main>
	<div class="container">

