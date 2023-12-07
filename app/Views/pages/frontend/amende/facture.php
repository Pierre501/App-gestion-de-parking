<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Facture d'amende</h3>
    <div class="col-sm-12">
        <div class="card mt-2 px-4">
            <div class="card-body">
                <h3 class="mt-5 text-center card-title">Facture n° <?= $infosPlace->getNumeroFactureOuTicket() ?></h3>
                <a href="<?= base_url("auth/amende/export-facture-en-pdf/".$infosPlace->getVoituresId()) ?>" target="_blank" class="float-end btn btn-outline-cyan"><i class="fas fa-file-pdf"></i> Exporter en pdf</a>
                <?php if(session("errorPayement")) : ?>
                    <div class="mt-2">
                        <div class="alert alert-danger alert-dismissible fade show text-center mt-4" role="alert">
                            <p><?= session("errorPayement") ?></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif ?>
                <div class="mt-5 w-50">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="p-style">La date et l'heure de début d'infraction :</p>
                            <p class="p-style">La date et l'heure actuelle :</p>
                            <p class="p-style">La dure d'une tranche d'amende :</p>
                            <p class="p-style">Le montant d'une tranche d'amende :</p>
                            <p class="p-style">La dure total d'infraction :</p>
                        </div>
                        <div>
                            <p><?= $infosPlace->getValeurDate($infosPlace->getDateFin()) ?> à <?= $infosPlace->getHeureFin() ?></p>
                            <p><?= date("d/m/Y") ?> à <?= date("H:i:s") ?></p>
                            <p><?= $amende->getTranche() ?> min</p>
                            <p><?= number_format($amende->getMontant(), 2, ",", " ") ?> Ar</p>
                            <p><?= $infosPlace->getDelais() ?> ou <?= number_format($infosPlace->getValeurDelaisEnMinute(), 0, "", " ") ?> minutes</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 table-responsive">
                    <table class="table">
                        <thead class="table-thead">
                            <tr>
                                <th class="fw-bold">Désignation</th>
                                <th class="fw-bold">Prix</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            <tr>
                                <td class="text-title">AMENDE D'INFRACTION</td>
                                <td></td>
                            </tr>
                            <?php foreach($listeDetailsAmende as $detailsAmende) : ?>
                                <tr>
                                    <td class="text-bold"><?= $detailsAmende['designation'] ?></td>
                                    <td rowspan="2" class="text-right"><?= number_format($detailsAmende['prix'], 2, ",", " ") ?> Ar</td>
                                </tr>
                                <tr>
                                    <td><?= $detailsAmende['dure'] ?> min</td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td class="text-bold">La dure total en minutes de la tranche d'une amende</td>
                                <td rowspan="2" class="text-right"><?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</td>
                            </tr>
                            <tr>
                                <td><?= number_format($infosPlace->getValeurDelaisEnMinute(), 0, "", " ") ?> min</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-tfoot">
                            <tr>
                                <td class="py-3 text-uppercase">Net à payé</td>
                                <td class="py-3"><?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-5">
                    <div class="float-start">
                        <p>Arrêtée la présente facture à la somme de :</p>
                        <p><?= $sommeMontantAmendeEnLettre ?> Ariary</p>
                    </div>
                    <div class="float-end">
                        <a href="<?= base_url("auth/amende/payement/".$infosPlace->getVoituresId()) ?>" class="btn btn-cyan text-white"> Payé</a>
                        <a href="<?= base_url("auth/amende") ?>" class="btn btn-secondary"> Annuler</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>