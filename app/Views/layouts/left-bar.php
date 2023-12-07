<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <?php if (!session("utilisateur")->isAdministrateur()) { ?>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/utilisateurs/accueil"); ?>" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Accueil</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/voiture") ?>" aria-expanded="false"><i class="mdi mdi mdi-car"></i><span class="hide-menu">Voiture</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/portefeuille") ?>" aria-expanded="false"><i class="mdi mdi-wallet"></i><span class="hide-menu">Portefeuille</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/tarifs") ?>" aria-expanded="false"><i class="mdi mdi-tag"></i><span class="hide-menu">Tarifs</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/amende") ?>" aria-expanded="false"><i class="mdi mdi-alert"></i><span class="hide-menu">Amende</span></a></li>
                <?php } else { ?>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/tableau-de-bord") ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Tableau de bord</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-asterisk"></i><span class="hide-menu"> Gestion places</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?= base_url("auth/place/liste") ?>" class="sidebar-link"><i class="mdi mdi-table"></i><span class="hide-menu"> Liste</span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-asterisk"></i><span class="hide-menu"> Gestion Tarifs</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?= base_url("auth/tarifs/page-ajout") ?>" class="sidebar-link"><i class="mdi mdi-plus-box-outline"></i><span class="hide-menu"> Ajout</span></a></li>
                            <li class="sidebar-item"><a href="<?= base_url("auth/tarifs/liste") ?>" class="sidebar-link"><i class="mdi mdi-table"></i><span class="hide-menu"> Liste</span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-asterisk"></i><span class="hide-menu"> Gestion utilisateurs</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?= base_url("auth/utilisateurs") ?>" class="sidebar-link"><i class="mdi mdi-table"></i><span class="hide-menu"> Liste</span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/portefeuille/liste-portefeuille-non-validé") ?>" aria-expanded="false"><i class="mdi mdi-wallet"></i><span class="hide-menu">Portefeuille</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/parametres") ?>" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Paramètre</span></a></li>
                <?php } ?>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("auth/utilisateurs/deconnexion"); ?>" aria-expanded="false"><i class="mdi mdi-logout"></i><span class="hide-menu">Déconnexion</span></a></li>
            </ul>
        </nav>
    </div>
</aside>