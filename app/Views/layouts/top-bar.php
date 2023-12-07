<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <a class="navbar-brand" href="<?= base_url("auth/utilisateurs/page-accueil") ?>">
                <b class="logo-icon ps-2"><i class="fs-2 text-success mdi mdi-car"></i></b>
                <span class="logo-text fw-bolder"><span class="text-danger">GESTION</span> DE <span class="text-warning">PARKING</span></span>
            </a>
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="#"><i class="ti-menu ti-close"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-start me-auto">
                <li class="nav-item d-none d-lg-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="#" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-md-block">Parking <i class="fa fa-angle-down"></i></span>
                        <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
                    </a>
                </li>
                <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="#"><i class="ti-search"></i></a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
            </ul>
            <ul class="navbar-nav float-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bell font-24"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" id="2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="font-24 mdi mdi-comment-processing"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown" aria-labelledby="2">
                        <ul class="list-style-none">
                            <li>
                                <div class=""></div>
                            </li>
                        </ul>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url("images/1.jpg"); ?>" alt="user" class="rounded-circle" width="31">
                        <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= base_url("auth/parametres/profile") ?>"><i class="ti-user me-1 ms-1"></i> <?= session("utilisateur")->getNom() ?></a>
                            <?php if(!session("utilisateur")->isAdministrateur()) : ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url("auth/parametres/page-modification-mot-de-passe") ?>"><i class="ti-settings me-1 ms-1"></i> Paramètre</a>
                            <?php endif ?>
                        </ul>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>