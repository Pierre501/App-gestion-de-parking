<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="voitures" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="suppressionPlacesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/voiture/suppression") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="suppressionPlacesLabel">Suppression voiture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment supprimer la voiture portant le matricule <span class="fw-bold" id="label_voitures"></span> ?</p>
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

<div class="row">
    <div class="d-flex justify-content-between">
        <h3 class="page-title">Liste de votre voitures</h3>
        <h5 class="page-title">Total voitures : <?= $totalVoitures ?> / 14</h5>
    </div>
    <?php if(session("errorTotalVoiture")) : ?>
        <div class="mt-2">
            <div class="alert alert-danger alert-dismissible fade show text-center mt-4" role="alert">
                <p><?= session("errorTotalVoiture") ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif ?>
    <?php if (!empty($listeVoiture)) : ?>
        <?php foreach ($listeVoiture as $voiture) : ?>
            <div class="col-md-6 col-lg-3 mt-2">
                <div class="card">
                    <div class="box <?= $voiture->getCouleur() ?> text-center">
                        <div class="float-end">
                            <div class="btn-group dropend">
                                <i class="fs-4 text-white cursor-pointer mdi mdi-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url("auth/voiture/page-modification/" . $voiture->getId()) ?>"><i class="mdi mdi-lead-pencil"></i> Modifier</a></li>
                                    <?php if ($voiture->getEtat() == 0) : ?>
                                        <li><a class="dropdown-item" href="#" id="suppression_voitures" value="<?= $voiture->getId() ?>" data-bs-toggle="modal" data-bs-target="#voitures"><i class="mdi mdi-delete"></i> Supprimer</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <h1 class="font-light text-white pt-4"><i class="fas fa-car"></i></h1>
                                <h6 class="text-white fs-5 pb-2"><?= $voiture->getStatus() ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3 text-center bg-white">
                        <span class="fs-4 text-bold"><?= $voiture->getMatricule() ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <div class="alert alert-success alert-dismissible fade show text-center mt-4" role="alert">
            <p>Vous n'avez pas encore ajouté votre voiture. Pour ajouté une voiture cliquer sur le bouton ci-dessous</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
</div>
<div class="row mt-4">
    <div class="col-sm-12">
        <div class="d-flex justify-content-center">
            <a href="<?= base_url("auth/voiture/page-ajout") ?>" class="btn btn-light rounded-circle shadow-sm"><i class="mdi mdi-plus text-cyan fs-3 fw-bolder"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>