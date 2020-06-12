<footer class="page-footer deep-purple center-on-small-only pt-0 bg-dark text-white">
    <div class="container">
        <div class="row pt-5 mb-3 text-center d-flex justify-content-center">
            <div class="col-md-2 mb-3">
                <h6 class="title font-bold"><a class="text-white" href="<?php echo BASE_URL ?>">Home</a></h6>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="title font-bold"><a class="text-white" href="<?php echo BASE_URL ?>/teachers">Daftar Guru</a></h6>
            </div>            
            <div class="col-md-2 mb-3">
                <h6 class="title font-bold"><a class="text-white" href="<?php echo BASE_URL ?>/users/permission">Permission</a></h6>
            </div>
        </div>
        <hr style="margin: 0 15%;border-color: inherit;">        
        <div class="row py-3">
            <div class="col-md-12">
                <div class="mb-2 text-center">
                    <a href="#" class="icons-sm text-white fb-ic"><i class="fa fa-facebook fa-lg white-text mr-md-4"> </i></a>
                    <a href="#" class="icons-sm text-white tw-ic"><i class="fa fa-twitter fa-lg white-text mx-md-4"> </i></a>
                    <a href="#" class="icons-sm text-white gplus-ic"><i class="fa fa-google-plus fa-lg white-text mx-md-4"> </i></a>
                    <a href="#" class="icons-sm text-white li-ic"><i class="fa fa-linkedin fa-lg white-text mx-md-4"> </i></a>
                    <a href="#" class="icons-sm text-white ins-ic"><i class="fa fa-instagram fa-lg white-text mx-md-4"> </i></a>
                    <a href="#" class="icons-sm text-white pin-ic"><i class="fa fa-pinterest fa-lg white-text ml-md-4"> </i></a>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container-fluid text-center pb-3">
            © <?= date("Y"); ?> Copyright:
            <a class="text-white" href="<?php echo BASE_URL ?>">
                <?= SITE_NAME ?>
            </a>
        </div>
    </div>
</footer>

<script type="text/javascript" src="<?= BASE_URL . '/js/owl.carousel.min.js' ?>"></script>
<script type="text/javascript" src="<?= BASE_URL . '/js/jquery.blockUI.js' ?>"></script>
<script type="text/javascript" src="<?= BASE_URL . '/js/permission.js' ?>"></script>
</body>
</html>