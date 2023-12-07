<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="portefeuille" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="portefeuilleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/portefeuille/validation-portefeuille") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="portefeuilleLabel">Validation portefeuille</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-check-circle-outline fs-1 text-success"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment validé le montant <span class="fw-bold" id="labelportefeuille"></span> Ar de la part de <span class="fw-bold" id="labelnomutilisateurs"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="portefeuilles_id" id="portefeuilles_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Portefeuille</h3>
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Liste portefeuille non validé</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nom client</th>
                                <th>Montant</th>
                                <th>Date et heure</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listePortefeuille as $portefeuille) : ?>
                                <tr>
                                    <td><?= $portefeuille->getNom() ?></td>
                                    <td><?= number_format($portefeuille->getMontant(), 2, ",", " ") ?> Ar</td>
                                    <td><?= $portefeuille->getValeurDate() ?> à <?= $portefeuille->getValeurHeure() ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success text-white" id="validationPortefeuille" value="<?= $portefeuille->getId() ?>" data-bs-toggle="modal" data-bs-target="#portefeuille"><i class="mdi mdi-check"></i> Valider</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>