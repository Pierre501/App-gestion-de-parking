<?= $this->extend("pages/login/app") ?>

<?= $this->section('content-login') ?>

<div class="card-body p-5 text-center">
    <h4 class="mb-4">Se connecter</h4>
    <?php if(session('erreur')) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('erreur') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <div class="position-relative">
        <form action="<?= base_url("connexion") ?>" method="post">
            <div class="form-outline mb-4">
                <input type="email" name="username" id="username" class="form-control" required>
                <label class="form-label pt-2" for="username">Nom d'utilisateur</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" name="motdepasse" id="motdepasse" class="form-control" required>
                <i class="position-absolute mdi mdi-eye-off" id="icon-login" onclick="showPassword()"></i>
                <label class="form-label pt-2" for="motdepasse">Mot de passe</label>
            </div>
            <div class="form-check mb-4">
                <label class="form-check-label float-start" for="checkbox">
                    <input class="form-check-input" type="checkbox" id="checkbox"> 
                    Souviens moi
                </label>
                <a href="<?= base_url("page-réinitialisation-mot-de-passe") ?>" class="float-end text-gray"> Mot de passe oublié ?</a>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-cyan btn-lg text-white"> Connexion</button>
            </div>
        </form>
    </div>
    <br>
    <div class="d-grid">
        <a href="<?= base_url("page-inscription") ?>" class="btn btn-secondary btn-lg">Créer un compte</a>
    </div>
    <hr class="my-4">
</div>

<?= $this->endSection() ?>