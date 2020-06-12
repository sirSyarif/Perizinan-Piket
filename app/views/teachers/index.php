<?php require BASE_ROOT . '/views/templates/header.php'; ?>
<div class="container">
    
    <?php if (isset($_SESSION['admin_mode'])) : ?>
        <?php Flash::getFlash() ?>
        <div class="row mb-3">
            <div class="col-md-6 mt-2">
                <h1 class="mb-0 text-dark"><i class="fa fa-shopping-bag"></i> Teachers</h1>
            </div>
            <div class="col-md-6">
                <a href="<?= BASE_URL . '/teachers/add' ?>" class="btn btn-dark pull-right"><i class="fa fa-pencil"></i> Add Teachers</a>
            </div>
        </div>
    <?php endif; ?>

    <?php require BASE_ROOT . '/views/templates/search.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <?php foreach ($data['teachers'] as $teacher) : ?>
                        <div class="col-lg-3 col-md-6 col-12 mt-3 mb-3 d-flex">
                            <div class="card border-secondary mb-xs-5 mt-xs-5">
                                <a href="<?= BASE_URL . '/teachers/show/' . $teacher->id ?>">
                                    <img class="card-img-top img-thumbnail Responsive image" src="<?= IMGPROD . $teacher->image; ?>" style="min-width: 240px;">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <strong>
                                            <a href="<?= BASE_URL . '/teachers/show/' . $teacher->id ?>">
                                                <?= $teacher->name; ?>
                                            </a>
                                        </strong>
                                    </h4>
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <?php foreach ($teacher->category as $category) : ?>
                                            <?= $category . " " ?>
                                        <?php endforeach; ?>
                                    </h6>
                                </div>
                                <div class="card-footer text-dark">
                                    Kelas: <?= $teacher->kelas ?>                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require BASE_ROOT . '/views/templates/pagination.php'; ?>
<?php require BASE_ROOT . '/views/templates/footer.php'; ?>