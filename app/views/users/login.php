<?php require BASE_ROOT .'/views/templates/header.php'; ?>
<div class="container my-5 pb-5">
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card border-secondary card-body bg-light mt-5 mb-5">
				<?php Flash::getFlash() ?>
				<h2 class="text-dark">Login</h2>			
				<form action="<?= BASE_URL . '/users/login' ?>" method="POST">
					<div class="form-group">
						<label for="email">Email: <sup>*</sup></label>
						<input type="email" name="email" class="form-control">						
					</div>
					<div class="form-group">
						<label for="password">Password: <sup>*</sup></label>
						<input type="password" name="password" class="form-control">						
					</div>
					<div class="row">
						<div class="col">
							<input type="submit" value="Login" class="btn btn-success btn-block">
						</div>
						<div class="col">
							<a href="<?=BASE_URL . '/users/register' ?>" class="btn btn-light btn-block">No account? Register</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require BASE_ROOT .'/views/templates/footer.php'; ?>