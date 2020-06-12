<?php require BASE_ROOT . '/views/templates/header.php'; ?>
<div class="container">
    <?php Flash::getFlash() ?>
    <?php require BASE_ROOT . '/views/templates/carousel.php'; ?>
</div>

<div class="container mb-5">
    <?php require BASE_ROOT . '/views/templates/search.php'; ?>
</div>

<hr style="margin: 0 5%;border-color: inherit;" class="mb-5">
<?php require BASE_ROOT . '/views/templates/footer.php'; ?>