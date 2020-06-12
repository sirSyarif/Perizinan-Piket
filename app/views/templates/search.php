<form action="<?= BASE_URL . '/teachers/page/1' ?>" method="GET">
    <div class="row">
        <div class="col-md-5 mb-1">
            <input value="<?= isset($_GET['teacher-search']) ? $_GET['teacher-search'] : ''; ?>" name="teacher-search" type="text" class="form-control" placeholder="Teacher Name">
        </div>
        <div class="col-md-5 mb-1">
            <select name="matpel" class="custom-select">
                <option value="0">Mata Pelajaran</option>
                <?php foreach ($data['typesList'] as $matpel) : ?>
                    <option <?= (isset($_GET['matpel']) && $_GET['matpel'] == $matpel->nama) ?
                            'selected="selected"' : ''; ?> value="<?php echo $matpel->nama ?>">
                        <?php echo $matpel->nama ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 mb-1">
            <button class="btn btn-outline-dark btn-block" type="submit"><i class="fa fa-search"></i> Find Teachers</button>
        </div>
    </div>
</form>