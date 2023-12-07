<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="tarifParkings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tarifParkingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/tarifs/suppression") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tarifParkingsLabel">Suppression tarif parking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment supprimer le <span class="fw-bold" id="labeltarifParkings"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="tarifParkings_id" id="tarifParkings_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Liste des tarifs</h3>
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tarifs</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Dure</th>
                                <th>Montant</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listeTarifParking as $tarifParking) : ?>
                                <tr>
                                    <td><?= $tarifParking->getTarif() ?></td>
                                    <td><?= $tarifParking->getHeureFormat() ?></td>
                                    <td><?= number_format($tarifParking->getMontant(), 2, ",", " ") ?> Ar</td>
                                    <td>
                                        <a href="<?= base_url("auth/tarifs/page-modification/".$tarifParking->getId()) ?>" class="btn btn-success text-white"><i class="mdi mdi-lead-pencil"></i> Modifier</a>
                                        <a href="#" class="btn btn-danger text-white" id="suppression_tarifParkings" value="<?= $tarifParking->getId() ?>" data-bs-toggle="modal" data-bs-target="#tarifParkings"><i class="mdi mdi-delete"></i> Supprimer</a>
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