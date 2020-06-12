<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['product-search'])) {
    define('GET_QRY', '?product-search=' . $_GET['product-search'] . '&product-category=' . $_GET['product-category']);
}

define('IMGSRC', BASE_URL . '/public/images/');
define('IMGPROD', BASE_URL . '/public/images/uploads/');