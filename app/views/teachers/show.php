<?php require BASE_ROOT . '/views/templates/header.php'; ?>
<div class="container">
    <div class="jumbotron text-center py-4 mb-3">
        <h1 class="text-dark jumbotron-text-shadow">Teachers Details</h1>
    </div>
</div>
<div class="container pb-5 mb-5">
    <a href="" class="btn btn-ligth m-1 back"><i class="fa fa-backward"></i> Back</a>
    <br>
    <div class="card border-secondary mb-5">
        <div class="row ">
            <div class="col-md-4">
                <img src="<?= IMGPROD . $data['teacher']->image; ?>" class="w-100 img-fluid">
            </div>
            <div class="col-md-5 p-3">
                <div class="card-body p-3">
                    <h3 class="card-title text-primary"><?= $data['teacher']->name ?></h3>
                    <span class="text-capitalize">Daftar Mata Pelajaran :</span>
                    <h6 class="card-subtitle mb-3 text-muted mt-2">                        
                        <?php foreach ($data['teacher']->category as $category) : ?>
                            <?= $category . " " ?>
                        <?php endforeach; ?>
                    </h6>
                    <p class="card-text text-dark">
                        Kelas <?= $data['teacher']->kelas ?>
                    </p>
                </div>
            </div>
            <div class="col-md-3">                
                <div class="card border-secondary text-center m-4">                    
                    <?php if(!isset($_SESSION['admin_mode'])) : ?>
                        <div class="card-body">                    
                            <button data-index="<?= $data['teacher']->id ?>" id="permission-button" class="btn btn-sm btn-dark mt-2">
                                <img id="permission-loader" style="display: none;" src="<?= IMGSRC . 'ajax-loader.gif' ?>" />
                                <i id="permission-icon" class="fa fa-book fa-lg"></i>
                                Add to Permission
                            </button>
                        </div>                    
                    <?php endif ?>
                </div>
                <?php if (isset($_SESSION['admin_mode'])) : ?>
                    <div class="card border-secondary text-center m-4">
                        <div class="card-header">
                            <h5 class="mb-0">ADMIN PANEL</h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= BASE_URL . '/teachers/edit/' . $data['teacher']->id ?>" class="btn btn-sm btn-info btn-block"><i class="fa fa-pencil-square-o"></i>Edit</a>
                            <hr>
                            <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i>
                                Delete
                            </button>
                        </div>
                        <div class="card-footer text-muted">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['admin_mode'])) : ?>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Teacher?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form class="pull-right" action="<?= BASE_URL . '/teachers/delete/' . $data['teacher']->id ?>" method="POST">
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require BASE_ROOT . '/views/templates/footer.php'; ?>