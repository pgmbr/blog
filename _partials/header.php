<?php require_once '_inc/config.php' ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>todoapp ajax</title>

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">

	<script>
		var baseURL = '<?php echo $base_url ?>';
	</script>
</head>
<body>

<header class="container">
	<!--navigation all that-->
	<?= flash()->display() ?>
</header>

<main>
	<div class="container">

