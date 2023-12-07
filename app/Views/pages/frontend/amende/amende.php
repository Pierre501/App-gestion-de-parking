<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Liste des amendes</h3>
    <div class="col-sm-12">
        <?php if (session("successPayement")) : ?>
            <div class="mt-2">
                <div class="alert alert-success alert-dismissible fade show text-center mt-4" role="alert">
                    <p><?= session("successPayement") ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif ?>
        <?php if (empty($listeInfosPlace)) : ?>
            <div class="alert alert-success alert-dismissible fade show text-center mt-4" role="alert">
                <p>Vous n'avez aucune amende</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php else : ?>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Amende</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Numéro place</th>
                                    <th>Matricule</th>
                                    <th>Délais infraction</th>
                                    <th>Montant à payé</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listeInfosPlace as $infosPlace) : ?>
                                    <tr>
                                        <td><?= $infosPlace->getNumero() ?></td>
                                        <td><?= $infosPlace->getMatricule() ?></td>
                                        <td><?= $infosPlace->getDelais() ?></td>
                                        <td><?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</td>
                                        <td>
                                            <a href="<?= base_url("auth/amende/facture/" . $infosPlace->getVoituresId()) ?>" class="btn btn-primary"><i class="mdi mdi-eye"></i> voir détails</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection() ?>