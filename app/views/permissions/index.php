<?php require BASE_ROOT . '/views/templates/header.php'; ?>
<div class="container">    
    <div id="permissions-index-jumbotron" class="jumbotron text-center py-4 mb-3">
        <h1 class="text-dark jumbotron-text-shadow">Permissions History</h1>
    </div>
</div>
<div class="container mt-1 mb-5">
	<?php foreach($data['permissions'] as $permission): ?>
	<div class="card border-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-md-0 mb-sm-2"><i class="fa fa-list-ul"></i> Permission</h4>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-0"><?= isset($_SESSION['admin_mode']) ? '<i class="fa fa-user"></i>ID Siswa: ' . $permission->siswa_id : ''; ?></h4>
                </div>
            </div>
        </div>
        <div class="card-body my-2">
            <div class="row align-items-center">
        		<div class="col-md-6">
					<h5 class="mb-0"><i class="fa fa-calendar"></i>Started : <?= $permission->started; ?></h5>
				</div>
				<div class="col-md-6">
					<h5 class="mb-0"><i class="fa fa-calendar"></i>Ended : <?= $permission->ended; ?></h5>
				</div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <a href="<?= BASE_URL . '/permissions/show/' . $permission->id ?>" class="btn btn-block btn-dark btn-sm">View Details</a>
        </div>
    </div>
    <hr style="margin: 0 5%; border-color: inherit;" class="my-3 border-secondary">
    <?php endforeach?>
</div>
<?php require BASE_ROOT .'/views/templates/paginationPerm.php'; ?>
<?php require BASE_ROOT .'/views/templates/footer.php'; ?>