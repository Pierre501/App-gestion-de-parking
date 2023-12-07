<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\PorteFeuille;
use App\Controllers\BaseController;
use App\Models\HistoriquePortefeuille;

class PorteFeuilleController extends BaseController
{
    public function index()
    {
        $title = "Page portefeuille";
        $session = session();
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get('utilisateur')->getId());
        $solde = $instanceUtilisateur->getSolde();
        $instanceHistoriquePortefeuille = new HistoriquePortefeuille();
        $instanceHistoriquePortefeuille->setUtilisateursId($session->get('utilisateur')->getId());
        $listeHistoriquePortefeuille = $instanceHistoriquePortefeuille->getAllHistoriquePortefeuilleByIdUtilisateurs();
        return view("pages/frontend/portefeuille/portefeuille", compact("title", "listeHistoriquePortefeuille", "solde"));
    }

    public function ajout()
    {
        $montant = $this->request->getVar("montant");
        $session = session();
        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setUtilisateursId($session->get('utilisateur')->getId());
        $instancePortefeuille->setMontant($montant);
        $instancePortefeuille->setMontantDepense(0);
        $instancePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setEtat(0);
        $verification = $instancePortefeuille->insertionPortefeuille();
        if($verification == false)
        {
            $errors = $instancePortefeuille->errors();
            return redirect()->to("auth/portefeuille")->with("errors", $errors);
        }
        $instanceHistoriquePortefeuille = new HistoriquePortefeuille();
        $instanceHistoriquePortefeuille->setPortefeuillleId($instancePortefeuille->getLastPortefeuillesId());
        $instanceHistoriquePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriquePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriquePortefeuille->insertionHistoriquePortefeuille();
        return redirect()->to("auth/portefeuille")->with("success", "Votre dépôt est bien effectué");
    }

    public function ajaxSuppressionHistoriquePortefeuille($id)
    {
        $instanceHistoriquePortefeuille = new HistoriquePortefeuille();
        $instanceHistoriquePortefeuille->setId($id);
        $dataHistoriquePortefeuille = $instanceHistoriquePortefeuille->getSimpleHistoriquePortefeuille()->getFullDataHistoriquePortefeuille();
        return $this->response->setJSON($dataHistoriquePortefeuille);
    }

    public function suppressionHistoriquePortefeuille()
    {
        $instanceHistoriquePortefeuille = new HistoriquePortefeuille();
        $instanceHistoriquePortefeuille->setId($this->request->getVar("historique_portefeuilles_id"));
        $instanceHistoriquePortefeuille->suppressionHistoriquePortefeuille();
        return redirect()->to("auth/portefeuille");
    }

    public function pagePortefeuille()
    {
        $title = "Liste des portefeuilles non validé";
        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setEtat(0);
        $listePortefeuille = $instancePortefeuille->getAllPortefeuilleUtilisateurs();
        return view("pages/backend/portefeuille/liste", compact("title", "listePortefeuille"));
    }

    public function ajaxValidationPortefeuille($id)
    {
        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setId($id);
        $dataPortefeuilleUtilisateur = $instancePortefeuille->getSimplePortefeuilleUtilisateurs()->getDataPortefeuilleUtilisateurs();
        return $this->response->setJSON($dataPortefeuilleUtilisateur);
    }

    public function validationPortefeuille()
    {
        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setId($this->request->getVar("portefeuilles_id"));
        $portefeuille = $instancePortefeuille->getSimplePortefeuille();
        $portefeuille->setEtat(1);
        $portefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $portefeuille->updatePortefeuille();
        return redirect()->to("auth/portefeuille/liste-portefeuille-non-validé");
    }
}
