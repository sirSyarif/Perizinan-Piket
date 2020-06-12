<?php require BASE_ROOT . '/views/templates/header.php' ?>
<div class="container">
	<div class="row">
		<div class="col-md-10 mx-auto">
			<a href="" class="btn btn-ligth back"><i class="fa fa-backward"></i> Back</a>
			<div class="card card-body bg-light mt-2 mb-5">
				<h2 class="text-dark">Edit Teacher</h2>
				<p>Edit Teacher with this form</p>
				<form action="<?= BASE_URL . '/teachers/edit/' . $data['id'] ?>" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="image">Image <em>Max 300KB</em></label>
								<input type="hidden" name="MAX_FILE_SIZE" value="300000">
								<input type="file" name="image" accept="image/*" onchange="loadFile(event)" class="form-control-file form-control-sm form-control" value="<?= $data['image'] ?>">
								<span class="invalid-feedback"><?= $data['image_err'] ?></span>
								<hr>
								<img id="output" class="w-100" src="<?= IMGPROD . $data['image'] ?>">
								<script>
								  	var loadFile = function(event) {
								    	var output = document.getElementById('output')
								    	output.src = URL.createObjectURL(event.target.files[0])
								  	}
								</script>
							</div>		
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="name">Nip: <sup>*</sup></label>
								<input type="text" name="nip" class="form-control form-control-sm" value="<?= $data['nip'] ?>">								
							</div>
							<div class="form-group">
								<label for="name">Name <sup>*</sup></label>
								<input type="text" name="name" class="form-control form-control-sm" value="<?= $data['name'] ?>">								
							</div>
							<div class="form-group">
								<label for="body">Kelas<sup>*</sup></label>
								<input type="text" name="kelas" class="form-control form-control-sm" value="<?= $data['kelas'] ?>">		
							</div>							
							<?php foreach($data['types'] as $type): ?>
								<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" value="<?= $type->id ?>" name="<?= $type->id ?>" id="<?= $type->id ?>" <?= $data['typesChecked'][$type->id] ?>>
								<label class="custom-control-label" for="<?= $type->id ?>">
									<?= $type->nama ?>
								</label>
								</div>							
							<?php endforeach ?>
						</div>
					</div>
					<input type="submit" class="btn btn-success" name="submit" value="Submit">
				</form>
			</div>
		</div>
	</div>
</div>
<?php require BASE_ROOT . '/views/templates/footer.php' ?>