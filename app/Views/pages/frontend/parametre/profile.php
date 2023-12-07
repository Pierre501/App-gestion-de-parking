<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Profile</h3>
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/parametres/modification-profile") ?>" method="post">
                <div class="card-body">
                    <?php if (!empty(session('errors_profiles'))) : ?>
                        <div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?php foreach (session('errors_profiles') as $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="nom" class="form-label">Nom <span class="fs-5 text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= session("utilisateur")->getSimpleNom() ?>" disabled required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="prenom" class="form-label">Prénom <span class="fs-5 text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= session("utilisateur")->getSimplePrenom() ?>" disabled required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="email" class="form-label">Email <span class="fs-5 text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= session("utilisateur")->getUsername() ?>" disabled required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center" id="button_profile">
                        <button type="submit" class="btn btn-cyan text-white" id="button_modification_profile"><i class="fas fa-pencil-alt"></i> Modifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>