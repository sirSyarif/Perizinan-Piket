<?php require BASE_ROOT . '/views/templates/header.php';?>
<div class="container">
	<div class="row">
		<div class="col-md-10 mx-auto">
			<a href="" class="btn btn-ligth back"><i class="fa fa-backward"></i> Back</a>
			<div class="card card-body bg-light mt-2 mb-5">
				<h2 class="text-dark">Add Teacher</h2>
				<p>Add Teacher with this form</p>
				<form action="<?= BASE_URL . '/teachers/add' ?>" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="image">Image <sup>*</sup> <em>Max 300KB</em></label>
								<input type="hidden" name="MAX_FILE_SIZE" value="300000">
								<input type="file" name="image" accept="image/*" onchange="loadFile(event)" class="form-control-file form-control-sm form-control <?= (!empty($data['image_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['image'] ?>">
								<span class="invalid-feedback"><?= $data['image_err'] ?></span>
								<hr>
								<img id="output" class="w-100">
								<script>
								  	var loadFile = function(event) {
								    	var output = document.getElementById('output');
								    	output.src = URL.createObjectURL(event.target.files[0]);
								  	};
								</script>
							</div>		
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nip">Nip <sup>*</sup></label>
								<input type="text" name="nip" class="form-control form-control-sm" value="<?= $data['nip'] ?>">								
							</div>
							<div class="form-group">
								<label for="name">Name <sup>*</sup></label>
								<input type="text" name="name" class="form-control form-control-sm" value="<?= $data['name'] ?>">								
							</div>
							<div class="form-group">
								<label for="name">Kelas: <sup>*</sup></label>
								<input type="text" name="kelas" class="form-control form-control-sm" value="<?= $data['kelas'] ?>">								
							</div>
							<?php foreach($data['types'] as $matpel): ?>
								<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" value="<?= $matpel->id ?>" name="<?= $matpel->id ?>" id="<?= $matpel->id ?>" <?= $data['typesChecked'][$matpel->id] ?>>
								<label class="custom-control-label" for="<?= $matpel->id; ?>">
									<?= $matpel->nama ?>
								</label>
								</div>								
							<?php endforeach; ?>
						</div>
					</div>
					<input type="submit" class="btn btn-success" name="submit" value="Submit">
				</form>
			</div>
		</div>
	</div>

</div>
<?php require BASE_ROOT . '/views/templates/footer.php';?>