<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Page de modification d'une voiture</h3>
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/voiture/modification") ?>" method="post">
                <div class="card-body">
                    <?php if (session("errors")) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach (session("errors") as $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="model" class="form-label">Modèle <span class="fs-5 text-danger">*</span></label>
                            <input type="text" class="form-control" id="model" name="model" value="<?= $voiture->getModel() ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="type" class="form-label">Type <span class="fs-5 text-danger">*</span></label>
                            <select name="types" id="types" class="form-select">
                                <option value="#" selected disabled>-- Séléctionner --</option>
                                <option value="Legères" <?php if ($voiture->getTypes() == "Legères") : ?> selected <?php endif ?>>Legères</option>
                                <option value="Lourds" <?php if ($voiture->getTypes() == "Lourds") : ?> selected <?php endif ?>>Lourds</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="marque" class="form-label">Marque <span class="fs-5 text-danger">*</span></label>
                            <input type="text" class="form-control" id="marque" name="marque" value="<?= $voiture->getMarque() ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="matricule" class="form-label">Matricule <span class="fs-5 text-danger">*</span></label>
                            <input type="text" class="form-control" id="matricule" name="matricule" value="<?= $voiture->getMatricule() ?>" disabled required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center">
                        <input type="hidden" name="voitures_id" value="<?= $voiture->getId() ?>">
                        <button type="submit" class="btn btn-success text-white"> Valider</button>
                        <a href="<?= base_url("/auth/voiture") ?>" class="btn btn-danger text-white"> Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>