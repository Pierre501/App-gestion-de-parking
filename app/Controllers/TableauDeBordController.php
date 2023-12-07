<?php

namespace App\Controllers;

use App\Models\Date;
use App\Models\InfosPlace;
use App\Models\Utilisateur;
use App\Controllers\BaseController;
use App\Models\Dette;
use App\Models\Payement;

class TableauDeBordController extends BaseController
{
    public function index()
    {
        $title = "Tableau de bord";
        $annee = date('Y');
        if($this->request->getVar("annee") !== null)
        {
            $annee = $this->request->getVar("annee");
        }
        $instanceDette = new Dette();
        $listeAnnee = range(2022, date('Y'));
        $instanceUtilisateur = new Utilisateur();
        $totalUtilisateurs = $instanceUtilisateur->getNombreTotalUtilisateurs();
        $totalNouveauUtilisateurs = $instanceUtilisateur->getNombreTotalNouveauUtilisateurs();
        $instanceInfosPlace = new InfosPlace();
        $listeInfosPlace = $instanceInfosPlace->getAllInfosPlace();
        $totalPlaces = count($listeInfosPlace);
        $totalLibres = $instanceInfosPlace->compteurEtatInfosPlaces($listeInfosPlace, "Libre");
        $totalOccupes = $instanceInfosPlace->compteurEtatInfosPlaces($listeInfosPlace, "Occupé");
        $totalInfraction = $instanceInfosPlace->compteurEtatInfosPlaces($listeInfosPlace, "En infraction");
        $totalMontantinfractions = $instanceInfosPlace->compteurMontantInfaction($listeInfosPlace);
        $moisEncoursStr = Date::formatMoisEncoursStr(Date::getStrMoisEncours(date('m')));
        $instanceDate = new Date();
        $listeDateDebutEtFinDuMois = $instanceDate->getDateDebutEtFinDuMois(date("m"), $annee);
        $listeDateDebutEtFinAnnee = $instanceDate->getDateDebutEtFinAnnee($annee);
        $instancePayement = new Payement();
        $instancePayement->setMotif("Paiement d'une amende sur un parking");
        $chiffreAffaireMensuelle = $instancePayement->getChiffreAffaireMensuelle($listeDateDebutEtFinDuMois[0], $listeDateDebutEtFinDuMois[1]);
        $chiffreAffaireAnnuelle = $instancePayement->getChiffreAffaireAnnuelle($listeDateDebutEtFinAnnee[0], $listeDateDebutEtFinAnnee[1]);
        $totalMontantAmendePaye = $instancePayement->getMontantAmendePaye($listeDateDebutEtFinDuMois[0], $listeDateDebutEtFinDuMois[1]) + $instanceDette->getSommeTotalDette();
        $dataStatiqueChiffreAffaireMensuelle = $instancePayement->getAllDataStatiqueChiffreAffaireMensuelle($annee);
        return view("pages/backend/home", compact("title", "annee", "listeAnnee", "totalPlaces", "moisEncoursStr", "totalLibres", "totalOccupes", "totalInfraction", "totalUtilisateurs", "totalNouveauUtilisateurs", "totalMontantinfractions", "chiffreAffaireAnnuelle", "chiffreAffaireMensuelle", "totalMontantAmendePaye", "dataStatiqueChiffreAffaireMensuelle"));
    }
}
