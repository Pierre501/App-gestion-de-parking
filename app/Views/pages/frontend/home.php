<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="ajoutVoitures" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ajoutVoituresLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?php if($verificationDette) : ?>
                <form action="<?= base_url("auth/amende/payement-dette") ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajoutVoituresLabel">Alerte amende non payé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Oups! vous ne pouvez pas ajouter une voiture car vous avez encors une dette d'amende <span class="text-bold"><?= number_format($dette->getMontant(), 2, ",", " ") ?> Ar</span> a rembourssé.</p>
                        <p>Si vous voulez payé l'amende cliquer sur le bouton <span class="text-bold">Oui</span>.</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal"> Non</button>
                        <button type="submit" class="btn btn-success text-white float-start w-45"> Oui</button>
                    </div>
                </form>
            <?php else: ?>
                <form action="<?= base_url("auth/stationnements/ajout") ?>" method="post">
                    <?php if (empty($listeVoiture)) : ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="ajoutVoituresLabel">Alerte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Oups! votre voiture sont tous occupées ou vous n'avez pas encors ajouté une voiture.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Fermer</button>
                        </div>
                    <?php else: ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajoutVoituresLabel">Formulaire d'ajout d'une voiture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <label class="form-label pt-2" for="voitures_id">Choix du voiture <span class="fs-5 text-danger">*</span></label>
                            <select name="voitures_id" id="voitures_id" class="form-select" required>
                                <option selected disabled>-- Séléctionner --</option>
                                <?php foreach ($listeVoiture as $voiture) : ?>
                                    <option value="<?= $voiture->getId() ?>"><?= $voiture->getMatricule() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label pt-2" for="tarifParkings_id">Choix du tarif <span class="fs-5 text-danger">*</span></label>
                            <select name="tarifParkings_id" id="tarifParkings_id" class="form-select" required>
                                <option selected disabled>-- Séléctionner --</option>
                                <?php foreach ($listeTarifParking as $tarifParking) : ?>
                                    <option value="<?= $tarifParking->getId() ?>"><?= $tarifParking->getTarif() ?> -- <?= $tarifParking->getHeureFormat() ?> -- <?= number_format($tarifParking->getMontant(), 2, ",", " ") ?> Ar</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <input type="hidden" name="places_id" id="places_id">
                        <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal"> Annuler</button>
                        <button type="submit" class="btn btn-success text-white float-start w-45"> Ajouter</button>
                    </div>
                    <?php endif ?>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="modal fade" id="enleve_voitures" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="suppressionPlacesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/stationnements/enleve") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="suppressionPlacesLabel">Enlevé une voiture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment enlevé votre voiture qui porte le matricule <span class="fw-bold" id="label_enleve_voitures"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="voitures_id" id="voiture_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Liste des voitures</h3>
    <?php if(session("erreur")) : ?>
        <div class="mt-2">
            <div class="alert alert-danger alert-dismissible fade show text-center mt-4" role="alert">
                <p><?= session("erreur") ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif ?>
    <?php if(session("errorEffraction")) : ?>
        <div class="mt-2">
            <div class="alert alert-danger alert-dismissible fade show text-center mt-4" role="alert">
                <p><?= session("errorEffraction") ?></p>
                <p>Cliquer ici pour <a href="<?= base_url("auth/amende") ?>" class="link-secondary fw-bold">voir les détails</a></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif ?>
    <?php if(session("error_dette")) : ?>
        <div class="mt-2">
            <div class="alert alert-danger alert-dismissible fade show text-center mt-4" role="alert">
                <p><?= session("error_dette") ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif ?>
    <?php foreach ($listeInfosPlace as $infosPlace) : ?>
        <?php if ($infosPlace->getEtat() == "Libre") : ?>
            <div class="col-md-6 col-lg-2 col-xlg-3 mt-3">
                <div class="card">
                    <div class="box <?= $infosPlace->getCouleur(); ?>">
                        <div class="float-end">
                            <div class="btn-group dropend">
                                <i class="fs-4 text-white cursor-pointer mdi mdi-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ajoutVoitures" id="ajout_voitures" value="<?= $infosPlace->getPlacesIdByNumeroPlace() ?>"><i class="mdi mdi-car-connected"></i> Ajouter une voiture</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <h1 class="font-light text-white py-3"><i class="<?= $infosPlace->getIcons(); ?>"></i></h1>
                            <h6 class="text-white">Numéro <?= $infosPlace->getNumero() ?></h6>
                            <h6 class="text-white">Libre</h6>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php if($infosPlace->checkProprietaireVoiture(session("utilisateur")->getId())) : ?>
                <div class="col-md-6 col-lg-2 col-xlg-3 mt-3">
                    <div class="card">
                        <div class="box <?= $infosPlace->getCouleur(); ?>">
                            <div class="float-end">
                                <div class="btn-group dropend">
                                    <i class="fs-4 text-white cursor-pointer mdi mdi-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" id="enlever_voitures"  data-bs-toggle="modal" value="<?= $infosPlace->getVoituresId() ?>" data-bs-target="#enleve_voitures"><i class="mdi mdi-car"></i> Enlever une voiture</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url("auth/stationnements/export-ticket-en-pdf/".$infosPlace->getStationnementsId()) ?>" target="_blank"><i class="mdi mdi-ticket"></i> Obtenir votre ticket</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <h1 class="font-light text-white py-3"><i class="<?= $infosPlace->getIcons(); ?>"></i></h1>
                                <h6 class="text-white">Numéro <?= $infosPlace->getNumero() ?></h6>
                                <h6 class="text-white"><?= $infosPlace->getMatricule() ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-md-6 col-lg-2 col-xlg-3 mt-3">
                    <div class="card">
                        <div class="box bg-warning">
                            <div class="text-center mt-3">
                                <h1 class="font-light text-white py-3"><i class="mdi mdi-car"></i></h1>
                                <h6 class="text-white">Numéro <?= $infosPlace->getNumero() ?></h6>
                                <h6 class="text-white">Occupés</h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endif; ?>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>