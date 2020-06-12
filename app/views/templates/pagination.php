<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <?php if ($data['totalPages'] > 1) : ?>
                <ul class="pagination justify-content-center">
                    <li class='page-item <?php ($data['page'] <= 1 ? print 'disabled' : '') ?>'>
                        <a class='page-link' href='<?= BASE_URL . '/teachers/page/1' ?><?= isset($_GET['teacher-search']) ? GET_QRY : '' ?>'>&laquo;</a>
                    </li>
                    <li class='page-item <?php ($data['page'] <= 1 ? print 'disabled' : '') ?>'>
                        <a class='page-link' href='<?= BASE_URL . '/teachers/page/' ?><?php ($data['page'] > 1 ? print($data['page'] - 1) : print 1) ?><?= isset($_GET['teacher-search']) ? GET_QRY : '' ?>'>&lsaquo;</a>
                    </li>
                    <?php for ($i = $data['start']; $i <= $data['end']; $i++) : ?>
                        <li class='page-item <?php ($i == $data['page'] ? print 'active' : '') ?>'>
                            <a class='page-link' href='<?= BASE_URL . '/teachers/page/' ?><?= $i ?><?= isset($_GET['teacher-search']) ? GET_QRY : '' ?>'><?= $i ?></a>
                        </li>
                    <?php endfor ?>
                    <li class='page-item <?php ($data['page'] >= $data['totalPages'] ? print 'disabled' : '') ?>'>
                        <a class='page-link' href='<?= BASE_URL . '/teachers/page/' ?><?php ($data['page'] < $data['totalPages'] ? print($data['page'] + 1) : print $data['totalPages']) ?><?= isset($_GET['teacher-search']) ? GET_QRY : '' ?>'>&rsaquo;</a>
                    </li>
                    <li class='page-item <?php ($data['page'] >= $data['totalPages'] ? print 'disabled' : '') ?>'>
                        <a class='page-link' href='<?= BASE_URL . '/teachers/page/' ?><?= $data['totalPages'] ?><?= isset($_GET['teacher-search']) ? GET_QRY : '' ?>'>&raquo;
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>