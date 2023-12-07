<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Page de modification d'un tarif</h3>
    <div class="col-sm-12">
        <div class="card mt-2">
            <form action="<?= base_url("auth/tarifs/modification") ?>" method="post">
                <div class="card-body">
                    <?php if(session("errors")) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach(session("errors") as $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="tarif" class="form-label">Tarif</label>
                            <input type="text" class="form-control" id="tarif" name="tarif" value="<?= $tarifParking->getTarif() ?>" disabled>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="dure" class="form-label">Duré <span class="fs-5 text-danger">*</span></label>
                            <input type="time" class="form-control" id="dure" name="dure" value="<?= $tarifParking->getDure() ?>" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="montant" class="form-label">Montant <span class="fs-5 text-danger">*</span></label>
                            <input type="number" class="form-control" id="montant" name="montant" value="<?= $tarifParking->getMontant() ?>" step="any" required>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center">
                        <input type="hidden" name="tarifParkings_id" value="<?= $tarifParking->getId() ?>">
                        <button type="submit" class="btn btn-success text-white"> Valider</button>
                        <a href="<?= base_url("auth/tarifs/liste") ?>" class="btn btn-danger text-white"> Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>