<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Modification mot de passe</h3>
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/parametres/modification-mot-de-passe") ?>" method="post">
                <div class="card-body">
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

<?= $this->endSection() ?>