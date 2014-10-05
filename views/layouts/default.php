<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?= $title_for_layout ?></title>
		<link rel="stylesheet" href="<?= WEBROOT ?>/public/css/app.css">
	</head>
	<body>

		<?php include(ROOT.'views/elements/menu.php'); ?>

		<?= $content_for_layout ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</body>
</html>