<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Paramètre</h3>
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/parametres/modification-mot-de-passe") ?>" method="post">
                <div class="card-body">
                    <h4 class="card-title">Modification mot de passe</h4>
                    <div class="row">
                        <?php if (!empty(session('error_password'))) : ?>
                            <div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <p><?= session('error_password') ?></p>
                            </div>
                        <?php endif ?>
                        <?php if (!empty(session('success_password'))) : ?>
                            <div class="alert alert-success alert-dismissible text-center fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <p><?= session('success_password') ?></p>
                            </div>
                        <?php endif ?>
                        <?php if (!empty(session('errors_passwords'))) : ?>
                            <div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php foreach (session('errors_passwords') as $error) : ?>
                                    <p><?= $error ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <div class="col-md-4 form-group">
                            <label for="ancien_motdepasse" class="form-label">Mot de passe <span class="fs-5 text-danger">*</span></label>
                            <input type="password" class="form-control" id="ancien_motdepasse" name="ancien_motdepasse" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="nouveau_motdepasse" class="form-label">Nouveau mot de passe <span class="fs-5 text-danger">*</span></label>
                            <input type="password" class="form-control" id="nouveau_motdepasse" name="nouveau_motdepasse" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="confirme_motdepasse" class="form-label">Confirme nouveau mot de passe <span class="fs-5 text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirme_motdepasse" name="confirme_motdepasse" required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-success text-white"> Valider</button>
                        <a href="<?= base_url("auth/utilisateurs/accueil") ?>" class="btn btn-danger text-white"> Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/parametres/modification") ?>" method="post">
                <div class="card-body">
                    <h4 class="card-title">Paramètre avancé</h4>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="type_parametre" class="form-label">Type <span class="fs-5 text-danger">*</span></label>
                            <select name="type_parametre" id="type_parametre" class="form-select" disabled>
                                <option value="Normale" <?php if($parametre->getOptions() == "Normale") : ?> selected <?php endif ?>>Normale</option>
                                <option value="Avance" <?php if($parametre->getOptions() == "Avance") : ?> selected <?php endif ?>>Avancé</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="date_parametre" class="form-label">Date <span class="fs-5 text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_parametre" name="date_parametre" value="<?= $parametre->getDateParametre() ?>" disabled required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="heure_parametre" class="form-label">Heure <span class="fs-5 text-danger">*</span></label>
                            <input type="time" class="form-control" id="heure_parametre" name="heure_parametre" value="<?= $parametre->getHeureParametre() ?>" disabled required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center" id="button_validation_modification">
                        <button type="button" id="button_modification" class="btn btn-cyan text-white"><i class="fas fa-pencil-alt"></i> Modifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/parametres/modification-amende") ?>" method="post">
                <div class="card-body">
                    <h4 class="card-title">Modification amende</h4>
                    <div class="row">
                        <?php if (!empty(session('amende_errors'))) : ?>
                            <div class="alert alert-success alert-dismissible text-center fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <p><?= session('amende_errors') ?></p>
                            </div>
                        <?php endif ?>
                        <div class="col-md-4 form-group">
                            <label for="nom_amende" class="form-label">Désignation</label>
                            <input type="text" class="form-control" id="nom_amende" name="nom_amende" value="<?= $amende->getNomAmende() ?>" disabled required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="tranche" class="form-label">Tranche <span class="fs-5 text-danger">*</span></label>
                            <input type="number" class="form-control" id="tranche" name="tranche" step="any" value="<?= $amende->getTranche() ?>" disabled required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="montant" class="form-label">Montant <span class="fs-5 text-danger">*</span></label>
                            <input type="number" class="form-control" id="montant" name="montant" step="any" value="<?= $amende->getMontant() ?>" disabled required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center" id="button_validation_modification_amende">
                        <button type="button" id="button_modification_amende" class="btn btn-cyan text-white"><i class="fas fa-pencil-alt"></i> Modifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>