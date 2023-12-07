<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="row">
<h3 class="page-title">Liste des tarifs</h3>
    <?php foreach($listeTarifParking as $tarifParking) { ?>
        <div class="col-md-6 col-lg-3 mt-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="box bg-cyan text-center">
                        <h6 class="text-white pt-2"><?= $tarifParking->getTarif() ?></h6>
                        <h1 class="font-light text-white py-4"><i class="fas fa-money-bill-alt"></i></h1>
                        <h6 class="text-white"><?= $tarifParking->getHeureFormat() ?></h6>
                        <h6 class="text-white"><?= number_format($tarifParking->getMontant(), 2, ',', ' ') ?> Ar</h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?= $this->endSection() ?>