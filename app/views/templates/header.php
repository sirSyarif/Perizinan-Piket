<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="id=edge">
	<title><?php echo SITE_NAME; ?> | <?= $data['title'] ?></title>
	
	<script src="<?= BASE_URL . '/public/js/jquery.min.js' ?>"></script>
	<script src="<?= BASE_URL . '/public/js/popper.min.js' ?>"></script>
	<script src="<?= BASE_URL . '/public/js/bootstrap.min.js' ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/public/css/bootstrap.min.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/public/css/font-awesome.min.css' ?>">	
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/public/css/owl.carousel.min.css' ?>">        
		
	<link href="<?= BASE_URL ?>/images/school.ico" rel="icon" type="image/x-icon" />
</head>
<body>
	<?php require BASE_ROOT . '/views/templates/navbar.php'; ?>