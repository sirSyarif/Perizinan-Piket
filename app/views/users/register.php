<?php require BASE_ROOT .'/views/templates/header.php'; ?>
<div class="container my-5 pb-5">
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body border-secondary bg-light mt-5 mb-5">
				<h2 class="text-dark">Create an account</h2>
				<p>Please fill out this form to register with us</p>
				<form action="<?= BASE_URL . '/users/register' ?>" method="POST">
					<div class="form-group">
						<label for="name">Name: <sup>*</sup></label>
						<input type="text" name="name" class="form-control" value="<?= $data['name'] ?>">
					</div>
					<div class="form-group">
						<label for="email">Email: <sup>*</sup></label>
						<input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
					</div>
					<div class="form-group">
						<label for="password">Password: <sup>*</sup></label>
						<input type="password" name="password" class="form-control" value="<?= $data['password'] ?>">
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password: <sup>*</sup></label>
						<input type="password" name="confirm_password" class="form-control" value="<?= $data['confirm_password'] ?>">
					</div>
					<div class="row">
						<div class="col">
							<input type="submit" value="Register" class="btn btn-success btn-block">
						</div>
						<div class="col">
							<a href="<?= BASE_URL; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require BASE_ROOT .'/views/templates/footer.php'; ?>