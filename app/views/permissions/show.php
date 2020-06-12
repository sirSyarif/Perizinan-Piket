<?php require BASE_ROOT .'/views/templates/header.php'; ?>
<div class="container">    
    <div id="permissions-show-jumbotron" class="jumbotron text-center py-4 mb-3">
        <h1 class="text-dark jumbotron-text-shadow">Permission Details</h1>
    </div>
</div>
<div class="container pb-5 mb-5">
    <a href="" class="btn btn-ligth mb-2 back"><i class="fa fa-backward"></i> Back</a>
    <br>
	<div id="cart-section" class="card border-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-md-0 mb-sm-2"><i class="fa fa-list-alt fa-lg"></i> Permission Details</h5>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fa fa-calendar fa-lg"></i> Started: <?= $data['started'] ?></h5>
                    <hr>
                    <h5 class="mb-0"><i class="fa fa-calendar fa-lg"></i> Ended: <?= $data['ended'] ?></h5>
                </div>
            </div>
        </div>
        <div class="card-body">            
            <?php foreach ($data['teachers'] as $teacher): ?>
                <div id="teacherRowId_<?= $teacher->id ?>">
                    <hr>                
                    <div class="row">
                        <div class="col-md-1"><a href="<?= BASE_URL . '/teacher/show/' . $teacher->id ?>"><img class="img-fluid" src="<?= IMGPROD . $teacher->image; ?>"></a>
                        </div>
                        <div class="col-md-6">
                            <h5 class="product-name mb-0"><strong><a href="<?= BASE_URL . '/teacher/show/' . $teacher->id ?>"><?= $teacher->name ?></a></strong></h5>
                            <p class="text-muted mb-0">
                                <?php foreach($teacher->category as $type): ?>
                                    <?= $type . " " ?>
                                <?php endforeach; ?>    
                            </p>
                        </div>
                        <div class="col-md-5">
                            <div class="row align-items-center text-center">
                                <div class="col-md-3">
                                    <h6 class="mb-0"><strong>$ <?= $teacher->name ?></strong></h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="mb-0"><strong><?= $teacher->quantity; ?></strong></h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="mb-0"><strong>$ <?= $teacher->linePrice; ?></strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>
</div>
<?php require BASE_ROOT .'/views/templates/footer.php'; ?>