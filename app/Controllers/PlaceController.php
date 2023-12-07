<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InfosPlace;
use App\Models\Parking;
use App\Models\Place;

class PlaceController extends BaseController
{
    public function index()
    {
        $title = "Liste des places";
        $instanceParking = new Parking();
        $listeParking = $instanceParking->getAllParkings();
        $instanceInfosPlace = new InfosPlace();
        $listeInfosPlace = $instanceInfosPlace->getAllInfosPlace();
        return view("pages/backend/place/liste", compact("title", "listeParking", "listeInfosPlace"));
    }

    public function ajout()
    {
        $parkingsId = $this->request->getVar("parkings_id");
        $nombrePlace = $this->request->getVar("nombre_place");
        $instancePlace = new Place();
        $instancePlace->setParkingsId($parkingsId);
        $instancePlace->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePlace->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePlace->insertionAllPlaces($nombrePlace);
        return redirect()->to("auth/place/liste");
    }

    public function ajaxSuppressionPlaces($id)
    {
        $instancePlace = new Place();
        $instancePlace->setId($id);
        $dataPlace = $instancePlace->getSimplePlaces()->getDataPlacesWithId();
        return $this->response->setJSON($dataPlace);
    }

    public function suppressionPlace()
    {
        $instancePlace = new Place();
        $instancePlace->setId($this->request->getVar("places_id"));
        $instancePlace->suppressionPlaces();
        return redirect()->to("auth/place/liste");
    }
}
