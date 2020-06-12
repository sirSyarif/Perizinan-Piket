<?php require BASE_ROOT . '/views/templates/header.php';?>
<div class="container">    
    <div id="users-permission-jumbotron" class="jumbotron text-center py-4 mb-3">
        <h1 class="text-dark jumbotron-text-shadow">Permission</h1>
    </div>
</div>
<div class="container mt-2 mb-5 pb-5">
    <?php Flash::getFlash() ?>
    <div id="permission-alert" style="display: none;" class="alert alert-dismissible alert-success fade show">
        <button type="button" class="close" id="permission-alert-close">&times;</button>
        <strong id="permission-message"></strong>
    </div>
	<div id="permission-section" class="card border-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fa fa-book fa-lg"></i> Permissions</h5>
                </div>
                <div class="col-md-6">
                    <a href="<?=  BASE_URL . '/teachers' ?>" class="btn btn-dark btn-sm btn-block">
                        <i class="fa fa-backward"></i> back
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-0">Permissions</h3>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <?php if (!empty($_SESSION['permission'])): ?>
            <form method="POST" action="" id="permission-form">                          
                <?php foreach ($data['teachers'] as $teacher): ?>
                    <?php $teacher->id ?>
                    <div id="teacherRowId_<?=  $teacher->id ?>">                    
                        <hr>                
                        <div class="row">
                            <div class="col-md-1"><a href="<?= BASE_URL . '/teachers/show/' . $teacher->id  ?>">
                                <img class="img-fluid" src="<?= IMGPROD . $teacher->image ?>"></a>
                            </div>
                            <div class="col-md-6">
                                <h5 class="product-name mb-0">
                                    <strong>
                                        <a href="<?= BASE_URL . '/teachers/show/' . $teacher->id ?>">
                                            <?= $teacher->name ?>
                                        </a>
                                    </strong>
                                </h5>
                                <p class="text-muted mb-0">
                                    Kelas : <?= $teacher->kelas ?>
                                </p>
                                <p class="text-muted mb-0">
                                    <?php foreach($teacher->category as $type): ?>
                                        <?= $type . " " ?>
                                    <?php endforeach; ?>    
                                </p>                                
                            </div>                            
                            <div class="col-md-5 text-center">
                                <button data-index="<?= $teacher->id ?>" type="button" class="btn btn-danger permission-delete-button">
                                    <i class="fa fa-trash-o fa-2x"></i> Delete
                                </button>                                                                
                            </div>
                        </div>
                    </div>
                <?php endforeach?>
            </form>            
            <?php endif;?>
        </div>
        <div class="card-footer text-muted">
            <div class="row align-items-center">                
                <div class="col-md-3">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <form method="POST" action="<?= BASE_URL . '/users/sendPermission' ?>">
                        <button id="permission-button" type="submit" <?php echo (isset($_SESSION['permission'])) ? '' : 'disabled'; ?> class="btn btn-success btn-block">
                            <i class="fa fa-send"></i> Send Permission
                        </button>
                    </form>
                    <?php else: ?>
                        <button id="permission-button" type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#permissionModal" <?php echo (isset($_SESSION['permission']) && array_sum($_SESSION['permission'])>0) ? '' : 'disabled'; ?>>
                            <i class="fa fa-send"></i> Send Permission
                        </button>
                        <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Login</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Come and log-in to start!
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a class="btn btn-primary pull-right" href="<?= BASE_URL . '/users/login' ?>">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <img id="throbber" style="display: none;" src="<?= IMGSRC ?>ajax-loader-2.svg">
</div>
<?php require BASE_ROOT . '/views/templates/footer.php';?>