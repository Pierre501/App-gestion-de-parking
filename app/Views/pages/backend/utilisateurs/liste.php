<?= $this->extend("layouts/app") ?>

<?= $this->section('content-app') ?>

<div class="modal fade" id="etat_utilisateurs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="utilisateursLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url("auth/utilisateurs/modification-etat-utilisateur") ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="utilisateursLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <i class="mdi mdi-alert fs-1 text-danger"></i>
                    </div>
                    <p class="text-center">Vous voulez vraiment <span class="fw-bold" id="labelutilisateurs"></span> l'utilisateur <span class="fw-bold" id="labelnomutilisateurs"></span> ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="utilisateurs_id" id="utilisateurs_id">
                    <button type="button" class="btn btn-secondary float-end w-45" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-danger text-white float-start w-45">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="page-title">Liste des utilisateurs</h3>
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Utilisateurs</h5>
                <div class="table-responsive mt-4">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nom et Prénom</th>
                                <th>Email</th>
                                <th>Actif</th>
                                <th>Date création</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listeUtilisateurs as $utilisateur) : ?>
                                <tr>
                                    <td><?= $utilisateur->getNom() ?> </td>
                                    <td><?= $utilisateur->getUsername() ?></td>
                                    <?php if($utilisateur->getEtat() == 1) : ?>
                                        <td><i class="cursor-pointer fs-4 fas fa-toggle-on" data-bs-toggle="modal" data-bs-target="#etat_utilisateurs" id="utilisateurs_etat" value="<?= $utilisateur->getId() ?>"></i></td>
                                    <?php else : ?>
                                        <td><i class="cursor-pointer fs-4 fas fa-toggle-off" data-bs-toggle="modal" data-bs-target="#etat_utilisateurs" id="utilisateurs_etat" value="<?= $utilisateur->getId() ?>"></i></td>
                                    <?php endif ?>
                                    <td><?= $utilisateur->getDateCreation() ?></td>
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