<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TarifParking;

class TarifController extends BaseController
{
    public function index()
    {
        $title = "Page liste des tarifs";
        $instanceTarifParking = new TarifParking();
        $listeTarifParking = $instanceTarifParking->getAllTarifParking();
        return view("pages/frontend/tarif/liste", compact("title", "listeTarifParking"));
    }

    public function liste()
    {
        $title = "Page liste des tarifs";
        $instanceTarifParking = new TarifParking();
        $listeTarifParking = $instanceTarifParking->getAllTarifParking();
        return view("pages/backend/tarif/liste", compact("title", "listeTarifParking"));
    }

    public function pageAjout()
    {
        $title = "Page d'ajout tarif";
        return view("pages/backend/tarif/ajout", compact("title"));
    }

    public function pageModification($id)
    {
        $title = "Page de modification tarif";
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($id);
        $tarifParking = $instanceTarifParking->getSimpleTarifParking();
        return view("pages/backend/tarif/modification", compact("title", "tarifParking"));
    }

    public function ajout()
    {
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setDure($this->request->getVar("dure"));
        $instanceTarifParking->setMontant($this->request->getVar("montant"));
        $instanceTarifParking->setTarif($instanceTarifParking->generateNomTarif());
        $instanceTarifParking->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceTarifParking->setUpdatedAt(date("Y-m-d H:i:s"));
        if($instanceTarifParking->insertionTarifParking() == false)
        {
            $errors = $instanceTarifParking->errors();
            return redirect()->to("auth/tarifs/page-ajout")->with("errors", $errors);
        }
        return redirect()->to("auth/tarifs/liste");
    }

    public function modification()
    {
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($this->request->getVar("tarifParkings_id"));
        $instanceTarifParking->setDure($this->request->getVar("dure"));
        $instanceTarifParking->setMontant($this->request->getVar("montant"));
        $tarifParking = $instanceTarifParking->getSimpleTarifParking();
        $instanceTarifParking->setTarif($tarifParking->getTarif());
        $instanceTarifParking->setCreatedAt($tarifParking->getCreatedAt());
        $instanceTarifParking->setUpdatedAt(date("Y-m-d H:i:s"));
        if($instanceTarifParking->updateTarifParking() == false)
        {
            $errors = $instanceTarifParking->errors();
            return redirect()->to("auth/tarifs/page-modification")->with("errors", $errors);
        }
        return redirect()->to("auth/tarifs/liste");
    }

    public function ajaxSuppression($id)
    {
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($id);
        $dataTarifParking = $instanceTarifParking->getSimpleTarifParking()->getDataTarifParkingById();
        return $this->response->setJSON($dataTarifParking);
    }

    public function suppression()
    {
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($this->request->getVar("tarifParkings_id"));
        $instanceTarifParking->suppressionTaridParking();
        return redirect()->to("auth/tarifs/liste");
    }
}
