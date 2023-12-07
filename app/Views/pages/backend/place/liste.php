<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>


<div class="modal fade" id="places" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="placesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/place/ajout") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="placesLabel">Formulaire d'ajout des places</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <label class="form-label pt-2" for="nombre_place">Choix du parking</label>
                        <select name="parkings_id" id="parkings_id" class="form-select" required>
                            <option value="#" selected disabled>-- Séléctionner --</option>
                            <?php foreach ($listeParking as $parking) : ?>
                                <option value="<?= $parking->getId() ?>"><?= $parking->getNomParking() ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label pt-2" for="nombre_place">Nombre des places</label>
                        <input type="number" name="nombre_place" id="nombre_place" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal"> Annuler</button>
                    <button type="submit" class="btn btn-success text-white float-start w-45"> Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="enleve_voitures_admin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="suppressionPlacesLabel" aria-hidden="true">
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
                    <p class="text-center">Vous voulez vraiment enlevé votre voiture qui porte le matricule <span class="fw-bold" id="label_enleve_voitures_admin"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="voitures_id" id="voitures_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="suppression_places" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="suppressionPlacesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/place/suppression-place") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="suppressionPlacesLabel">Suppression place</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment supprimer la place <span class="fw-bold" id="label_suppression_places"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="places_id" id="places_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Liste des places</h3>
    <?php foreach ($listeInfosPlace as $infosPlace) : ?>
        <?php if ($infosPlace->getEtat() == "Libre") : ?>
            <div class="col-md-6 col-lg-2 col-xlg-3 mt-3">
                <div class="card">
                    <div class="box <?= $infosPlace->getCouleur(); ?>">
                        <div class="float-end">
                            <div class="btn-group dropend">
                                <i class="fs-4 text-white cursor-pointer mdi mdi-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" id="suppression_places_id" value="<?= $infosPlace->getPlacesId() ?>" data-bs-toggle="modal" data-bs-target="#suppression_places"><i class="mdi mdi-delete"></i> Supprimer</a></li>
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
            <div class="col-md-6 col-lg-2 col-xlg-3 mt-3 tooltips">
                <div class="card">
                    <div class="box <?= $infosPlace->getCouleur(); ?>">
                        <div class="float-end">
                            <div class="btn-group dropend">
                                <i class="fs-4 text-white cursor-pointer mdi mdi-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" id="enlever_voitures_admin" data-bs-toggle="modal" value="<?= $infosPlace->getVoituresId() ?>" data-bs-target="#enleve_voitures_admin"><i class="mdi mdi-car"></i> Enlever une voiture</a></li>
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
                <div class="tooltipstext">
                    <div class="p-3">
                        <p class="text-center fs-5 fw-bold">Numéro <?= $infosPlace->getNumero() ?></p>
                        <p>Etat : <?= $infosPlace->getEtat() ?></p>
                        <p>Heure d'arrivé : <?= $infosPlace->getValeurDate($infosPlace->getDateDebut()) ?> à <?= $infosPlace->getHeureDebut() ?></p>
                        <p>Duré prévue : <?= $infosPlace->getValeurDate($infosPlace->getDateFin()) ?> à <?= $infosPlace->getHeureFin() ?></p>
                    <?php if($infosPlace->getEtat() == "Occupé") : ?>
                        <p>Délai de départ : <?= $infosPlace->getDelais() ?></p>
                    <?php else : ?>
                        <p>Duré infraction : <?= $infosPlace->getDelais() ?></p>
                        <p>Amende à payé : <?= number_format($infosPlace->getMontantAmende(), 2, ",", " ") ?> Ar</p>
                    <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>

<div class="row mt-4">
    <div class="col-sm-12">
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-success rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#places"><i class="mdi mdi-plus text-white fs-3 fw-bolder"></i></button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>