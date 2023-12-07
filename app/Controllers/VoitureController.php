<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Voiture;

class VoitureController extends BaseController
{
    public function index()
    {
        $title = "Liste des voitures";
        $session = session();
        $instanceVoiture = new Voiture();
        $instanceVoiture->setUtilisateursId($session->get("utilisateur")->getId());
        $listeVoiture = $instanceVoiture->getAllVoitureByUtilisateur();
        $totalVoitures = count($listeVoiture);
        return view("pages/frontend/voiture/liste", compact("title", "listeVoiture", "totalVoitures"));
    }

    public function pageAjout()
    {
        $title = "Page d'ajout d'une voiture";
        return view("pages/frontend/voiture/ajout", compact("title"));
    }

    public function pageModification($id)
    {
        $title = "Page de modification d'une voiture";
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($id);
        $voiture = $instanceVoiture->getSimpleVoiture();
        return view("pages/frontend/voiture/modification", compact("title", "voiture"));
    }

    public function ajout()
    {
        $session = session();
        $instanceVoiture = new Voiture();
        $instanceVoiture->setUtilisateursId($session->get("utilisateur")->getId());
        if($instanceVoiture->getTotalVoitureByUtilisateurs() == 14)
        {
            $error = "Vous ne pouvez plus ajouter une autre voiture car les nombres des voitures sont limités à 14";
            return redirect()->to("auth/voiture")->with("errorTotalVoiture", $error);
        }
        $instanceVoiture->setModel($this->request->getVar("model"));
        $instanceVoiture->setMarque($this->request->getVar("marque"));
        $instanceVoiture->setTypes($this->request->getVar("types"));
        $instanceVoiture->setMatricule($this->request->getVar("matricule"));
        $instanceVoiture->setEtat(0);
        $instanceVoiture->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceVoiture->setUpdatedAt(date("Y-m-d H:i:s"));
        if(is_array($instanceVoiture->insertionVoitures()))
        {
            $errors = $instanceVoiture->insertionVoitures();
            return redirect()->to("/auth/voiture/page-ajout")->with("errors", $errors);
        }
        return redirect()->to("/auth/voiture");
    }

    public function modification()
    {
        $voituresId = $this->request->getVar("voitures_id");
        $session = session();
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($voituresId);
        $voiture = $instanceVoiture->getSimpleVoiture();
        $instanceVoiture->setUtilisateursId($session->get("utilisateur")->getId());
        $instanceVoiture->setModel($this->request->getVar("model"));
        $instanceVoiture->setMarque($this->request->getVar("marque"));
        $instanceVoiture->setTypes($this->request->getVar("types"));
        $instanceVoiture->setMatricule($voiture->getMatricule());
        $instanceVoiture->setEtat($voiture->getEtat());
        $instanceVoiture->setCreatedAt($voiture->getCreatedAt());
        $instanceVoiture->setUpdatedAt(date("Y-m-d H:i:s"));
        if($instanceVoiture->updateVoiture() == false)
        {
            $errors = $instanceVoiture->errors();
            return redirect()->to("/auth/voiture/page-modification/".$voituresId)->with("errors", $errors);
        }
        return redirect()->to("/auth/voiture");
    }

    public function ajaxSuppression($id)
    {
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($id);
        $dataVoiture = $instanceVoiture->getSimpleVoiture()->getDataVoitureById();
        return $this->response->setJSON($dataVoiture);
    }

    public function suppression()
    {
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($this->request->getVar("voitures_id"));
        $instanceVoiture->suppressionVoiture();
        return redirect()->to("/auth/voiture");
    }
}
