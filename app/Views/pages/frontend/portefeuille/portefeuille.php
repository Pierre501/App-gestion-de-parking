<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="historiquePortefeuille" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="historiquePortefeuilleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/portefeuille/suppression-historique-portefeuille") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="historiquePortefeuilleLabel">Suppression historique portefeuille</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment supprimer l'historique du montant <span class="fw-bold" id="labelhistoriquePortefeuille"></span> Ar ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="historique_portefeuilles_id" id="historique_portefeuilles_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Portefeuille</h3>
    <div class="col-md-6 mt-4">
        <div class="card">
            <form action="<?= base_url("auth/portefeuille/ajout") ?>" method="post">
                <div class="card-body">
                    <h4 class="card-title">Formulaire pour récharge votre portefeuille</h4>
                    <?php if (session('success')) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if (session('errors')) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach (session('errors') as $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <div class="input-group">
                            <input type="number" step="any" class="form-control" id="montant" name="montant" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success text-white">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Montant actuelle dans votre portefeuille</h5>
                <div class="form-group">
                    <label for="montant">Solde</label>
                    <input type="text" id="montant" name="montant" value="<?= number_format($solde, 2, ",", " ") ?> Ar" class="form-control demo" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Historique récharge portefeuille</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Montant</th>
                                <th>Validation</th>
                                <th>Date et heure</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listeHistoriquePortefeuille as $historiquePortefeuille) : ?>
                                <tr>
                                    <td><?= number_format($historiquePortefeuille->getMontant(), 2, ",", " ") ?> Ar</td>
                                    <td><?= $historiquePortefeuille->getValeurValidation() ?></td>
                                    <td><?= $historiquePortefeuille->getValeurDate() ?> à <?= $historiquePortefeuille->getValeurHeure() ?></td>
                                    <td>
                                        <a href="#" class="btn btn-danger text-white" id="suppressionHistoriquePortefeuille" value="<?= $historiquePortefeuille->getId() ?>" data-bs-toggle="modal" data-bs-target="#historiquePortefeuille"><i class="mdi mdi-delete"></i> Supprimer</a>
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