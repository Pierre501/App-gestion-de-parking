<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
    <h3 class="page-title">Tableau de bord mois <?= $moisEncoursStr ?> <?= $annee ?></h3>
    <div class="col-md-6 col-lg-3 mt-2">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white pt-2"><i class="mdi mdi-tag-multiple"></i></h1>
                <h6 class="text-white fs-5 py-2">Chiffre d'affaire annuelle</h6>
            </div>
            <div class="card-footer py-3 text-center bg-white">
                <span class="fs-4 text-bold"><?= number_format($chiffreAffaireAnnuelle, 2, ",", " ") ?> Ar</span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mt-2">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <h1 class="font-light text-white pt-2"><i class="mdi mdi-tag"></i></h1>
                <h6 class="text-white fs-5 py-2">Chiffre d'affaire mensuelle</h6>
            </div>
            <div class="card-footer py-3 text-center bg-white">
                <span class="fs-4 text-bold"><?= number_format($chiffreAffaireMensuelle, 2, ",", " ") ?> Ar</span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mt-2">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white pt-2"><i class="mdi mdi-check"></i></h1>
                <h6 class="text-white fs-5 py-2">Total amende payé</h6>
            </div>
            <div class="card-footer py-3 text-center bg-white">
                <span class="fs-4 text-bold"><?= number_format($totalMontantAmendePaye, 2, ",", " ") ?> Ar</span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mt-2">
        <div class="card card-hover">
            <div class="box bg-warning text-center">
                <h1 class="font-light text-white pt-2"><i class="mdi mdi-alert"></i></h1>
                <h6 class="text-white fs-5 py-2">Total amende non payé</h6>
            </div>
            <div class="card-footer py-3 text-center bg-white">
                <span class="fs-4 text-bold"><?= number_format($totalMontantinfractions, 2, ",", " ") ?> Ar</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Statistique</h4>
                        <h5 id="visit-sale-chart-legend" class="card-subtitle rounded-legend legend-horizontal legend-top-right ps-0"></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 mt-2">
                        <canvas id="visit-sale-chart"></canvas>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <div class="row">
                        <div class="col-12">
                            <form action="<?= base_url("auth/tableau-de-bord/filtre") ?>" method="post">
                                <div class="input-group mb-3">
                                    <select name="annee" id="annee" class="form-select">
                                    <?php foreach($listeAnnee as $annees) : ?>
                                        <option value="<?= $annees ?>" <?php if($annees == $annee) : ?> selected <?php endif ?>><?= $annees ?></option>
                                    <?php endforeach ?>
                                    </select>
                                    <button type="submit" class="btn btn-cyan text-white"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                            <div class="col-6 mt-5">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fa fa-user mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalUtilisateurs ?></h5>
                                    <small class="font-light">Total utilisateurs</small>
                                </div>
                            </div>
                            <div class="col-6 mt-5">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fas fa-user-plus mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalNouveauUtilisateurs ?></h5>
                                    <small class="font-light">Nouveau utilisateurs</small>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fas fa-road mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalPlaces ?></h5>
                                    <small class="font-light">Total places</small>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fas fa-road mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalLibres ?></h5>
                                    <small class="font-light">Total libres</small>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fa fa-car mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalOccupes ?></h5>
                                    <small class="font-light">Total occupés</small>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="bg-dark p-10 text-white text-center">
                                    <i class="fas fa-exclamation-triangle mb-1 font-16"></i>
                                    <h5 class="mb-0 mt-1"><?= $totalInfraction ?></h5>
                                    <small class="font-light">Total infractions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>