<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Dette;
use App\Models\InfosPlace;
use App\Models\TarifParking;
use App\Models\Utilisateur;
use App\Models\Voiture;

class UtilisateurController extends BaseController
{
    public function index()
    {
        $title = "Page d'accueil";
        $session = session();
        $instanceVoiture = new Voiture();
        $instanceVoiture->setUtilisateursId($session->get("utilisateur")->getId());
        $instanceVoiture->setEtat(0);
        $listeVoiture = $instanceVoiture->getAllVoitureNonOccupeByUtilisateur();
        $instanceTarifParking = new TarifParking();
        $listeTarifParking = $instanceTarifParking->getAllTarifParking();
        $instanceInfosPlace = new InfosPlace();
        $listeInfosPlace = $instanceInfosPlace->getAllInfosPlace();
        $instanceDette = new Dette();
        $verificationDette = $instanceDette->verificationDetteUtilisateur($session->get("utilisateur")->getId());
        $dette = null;
        if($verificationDette)
        {
            $dette = $instanceDette->getSimpleDetteByUtilisateurId($session->get("utilisateur")->getId());
        }
        return view("pages/frontend/home", compact("title", "listeInfosPlace", "listeVoiture", "listeTarifParking", "verificationDette", "dette"));
    }

    public function logout()
    {
        $session = session();
        $session->remove("utilisateur");
        return redirect()->to("/");
    }

    public function liste()
    {
        $title = "Liste des utilisateurs";
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setRoles(0);
        $listeUtilisateurs = $instanceUtilisateur->getAllUtilisateurs();
        return view("pages/backend/utilisateurs/liste", compact("title", "listeUtilisateurs"));
    }

    public function accueil()
    {
        $session = session();
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        if(!$instanceUtilisateur->isAdministrateur())
        {
            return redirect()->to("auth/utilisateurs/accueil");
        }
        return redirect()->to("auth/tableau-de-bord");
    }

    public function ajaxutilisateur($id)
    {
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($id);
        $data1['id'] = $id;
        $data2 = $instanceUtilisateur->getSimpleUtilisateurById()->getDataUtilisateurs();
        $dataUtilisateur = array_merge($data1, $data2);
        return $this->response->setJSON($dataUtilisateur);
    }

    public function modificationetat()
    {
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($this->request->getVar("utilisateurs_id"));
        $utilisateur = $instanceUtilisateur->getSimpleUtilisateurById();
        $instanceUtilisateur->setNom($utilisateur->getNom());
        $instanceUtilisateur->setUsername($utilisateur->getUsername());
        $instanceUtilisateur->setMotdepasse($utilisateur->getMotdepasse());
        $instanceUtilisateur->setEtat(0);
        $instanceUtilisateur->setRoles($utilisateur->getRoles());
        $instanceUtilisateur->setCreatedAt($utilisateur->getCreatedAt());
        $instanceUtilisateur->setUpdatedAt(date("Y-m-d H:i:s"));
        if($utilisateur->getEtat() == 0)
        {
            $instanceUtilisateur->setEtat(1);
        }
        $instanceUtilisateur->updateUtilisateur();
        return redirect()->to(base_url("auth/utilisateurs"));
    }
}
