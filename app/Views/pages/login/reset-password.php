<?= $this->extend("pages/login/app") ?>

<?= $this->section('content-login') ?>

<div class="card-body p-5 text-center">
    <h4 class="mb-4">Réinitialisé mot de passe</h4>
    <form action="#" method="post">
        <p class="card-text">Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.</p>
        <div class="form-outline mb-4">
            <input type="email" name="username" id="username" class="form-control" required>
            <label class="form-label pt-2" for="username">Adresse e-mail</label>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-secondary btn-lg"> Envoyer</button>
        </div>
    </form>
</div>


<?= $this->endSection() ?>