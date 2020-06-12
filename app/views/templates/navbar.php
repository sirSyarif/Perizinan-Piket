<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><?php echo SITE_NAME; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/Teachers">Daftar Guru</a>
                </li>                
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isLoggedIn()) : ?>
                    <?php if (isset($_SESSION['admin_mode'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/permissions"><?php echo $_SESSION['user_name'] ?></a>
                        </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $_SESSION['user_name'] ?></a>
                    </li>
                    <?php endif ?>
                    <?php if (!isset($_SESSION['admin_mode'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/users/permission"><i class="fa fa-book fa-lg"></i>
                                <strong id="permissionItems">
                                    <?php if (isset($_SESSION['permission'])) : ?>
                                        <?php echo array_sum($_SESSION['permission']) ?>
                                    <?php else : ?>
                                        <?php echo 0 ?>
                                    <?php endif; ?>
                                </strong> Permission</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link btn" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </li>

                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/users/permission"><i class="fa fa-book fa-lg"></i>
                            <strong id="permissionItems">
                                <?php if (isset($_SESSION['permission'])) : ?>
                                    <?php echo array_sum($_SESSION['permission']) ?>
                                <?php else : ?>
                                    <?php echo 0 ?>
                                <?php endif; ?>
                            </strong> Permission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/users/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/users/login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to Logout ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger">
                    <a class="text-white text-decoration-none" href="<?php echo BASE_URL . '/users/logout/' ?>">
                        Logout
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>