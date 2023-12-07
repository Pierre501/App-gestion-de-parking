<?= $this->extend("pages/login/app") ?>

<?= $this->section('content-login') ?>

<div class="card-body p-5 text-center">
    <h4 class="mb-4">Inscription</h4>
    <?php if (!empty(session('errors_register'))) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php foreach (session('errors_register') as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <form action="<?= base_url("inscription") ?>" method="post">
        <div class="form-outline mb-4">
            <input type="text" name="nom" id="nom" class="form-control" required>
            <label class="form-label pt-2" for="nom">Nom et Prénom <span class="fs-5 text-danger">*</span></label>
        </div>
        <div class="form-outline mb-4">
            <input type="email" name="username" id="username" class="form-control" required>
            <label class="form-label pt-2" for="username">Adresse e-mail <span class="fs-5 text-danger">*</span></label>
        </div>
        <div class="form-outline mb-4">
            <input type="password" name="motdepasse" id="motdepasse" class="form-control" required>
            <label class="form-label pt-2" for="motdepasse">Mot de passe <span class="fs-5 text-danger">*</span></label>
        </div>
        <div class="form-outline mb-4">
            <input type="password" name="motdepasseconfirme" id="motdepasseconfirme" class="form-control" required>
            <label class="form-label pt-2" for="motdepasseconfirme">Confirme mot de passe <span class="fs-5 text-danger">*</span></label>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-secondary btn-lg"> Créer</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>