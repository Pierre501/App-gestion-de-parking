<?php

namespace App\Controllers;

use App\Models\PDF;
use App\Models\Heure;
use App\Models\Voiture;
use App\Models\Payement;
use App\Models\InfosPlace;
use App\Models\Utilisateur;
use App\Models\PorteFeuille;
use App\Models\TarifParking;
use App\Models\Stationnement;
use App\Models\ChiffreEnLettre;
use App\Controllers\BaseController;
use App\Models\Dette;
use App\Models\HistoriqueStationnement;

class StationnementController extends BaseController
{
    public function ajout()
    {
        $session = session();
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());

        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($this->request->getVar("tarifParkings_id"));
        $tarif = $instanceTarifParking->getSimpleTarifParking();

        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($this->request->getVar("voitures_id"));
        $voiture = $instanceVoiture->getSimpleVoiture();
        $instanceVoiture->setUtilisateursId($voiture->getUtilisateursId());
        $instanceVoiture->setModel($voiture->getModel());
        $instanceVoiture->setMarque($voiture->getMarque());
        $instanceVoiture->setMatricule($voiture->getMatricule());
        $instanceVoiture->setTypes($voiture->getTypes());
        $instanceVoiture->setEtat(1);
        $instanceVoiture->setCreatedAt($voiture->getCreatedAt());
        $instanceVoiture->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceVoiture->updateVoiture();

        if($tarif->getMontant() > $instanceUtilisateur->getSolde())
        {
            $erreur = "Votre solde est insuffisant pour effectué cette operation, veuillez recharger votre portefeuille";
            return redirect()->to(base_url("auth/utilisateurs/accueil"))->with("erreur", $erreur);
        }
        
        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePortefeuille->setMontant(0);
        $instancePortefeuille->setMontantDepense($tarif->getMontant());
        $instancePortefeuille->setEtat(1);
        $instancePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->insertionPortefeuille();

        $instancePayement = new Payement();
        $instancePayement->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePayement->setTarifParkingId($this->request->getVar("tarifParkings_id"));
        $instancePayement->setPlacesId($this->request->getVar("places_id"));
        $instancePayement->setMontant($tarif->getMontant());
        $instancePayement->setMotif("Paiement d'une place sur un parking");
        $instancePayement->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePayement->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePayement->insertionPayement();

        $instanceHeure = new Heure();
        $nouveauInstanceHeure = $instanceHeure->getSommeHeure(date('H:i:s'), $tarif->getDure());
        $nouveauInstanceHeure->setAnnee(date('Y'));
        $nouveauInstanceHeure->setMois(date('m'));
        $nouveauInstanceHeure->setJour(date('d'));

        $instanceStationnement = new Stationnement();
        $instanceStationnement->setVoituresId($this->request->getVar("voitures_id"));
        $instanceStationnement->setPlacesId($this->request->getVar("places_id"));
        $instanceStationnement->setTarifParkingsId($this->request->getVar("tarifParkings_id"));
        $instanceStationnement->setParametresId(1);
        $instanceStationnement->setDateDebut(date("Y-m-d"));
        $instanceStationnement->setHeureDebut(date("H:i:s"));
        $instanceStationnement->setDateFin($nouveauInstanceHeure->getDateFin());
        $instanceStationnement->setHeureFin($nouveauInstanceHeure->getHeureFin());
        $instanceStationnement->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceStationnement->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceStationnement->insertionStationnements();

        return redirect()->to(base_url("auth/utilisateurs/accueil"));
    }

    public function ajaxEnleveVoiture($id)
    {
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($id);
        $dataVoiture = $instanceVoiture->getSimpleVoiture()->getDataVoitureById();
        return $this->response->setJSON($dataVoiture);
    }

    public function enleve()
    {
        $session = session();
        $baseUrl = "auth/utilisateurs/accueil";
        $voituresId = $this->request->getVar("voitures_id");
        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($voituresId);

        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        if($instanceUtilisateur->isAdministrateur())
        {
            $instanceInfosPlace = new InfosPlace();
            $instanceInfosPlace->setVoituresId($voituresId);

            $instanceDette = new Dette();
            $instanceDette->setVoituresId($voituresId);
            $instanceDette->setMontant($instanceInfosPlace->getSimpleMontantAmende());
            $instanceDette->setCreatedAt(date("Y-m-d H:i:s"));
            $instanceDette->setUpdatedAt(date("Y-m-d H:i:s"));
            $instanceDette->insertionDette();
            $baseUrl = "auth/place/liste";
        }
        else
        {
            if($instanceVoiture->verificationEffractionVoiture())
            {
                $errorEffraction = "Oups! vous ne pouvez pas effectué cette opération car votre voiture est en etat d'effraction.";
                return redirect()->to(base_url("auth/utilisateurs/accueil"))->with("errorEffraction", $errorEffraction);
            }
        }

        $instanceStationnement = new Stationnement();
        $instanceStationnement->setVoituresId($voituresId);
        $stationnement = $instanceStationnement->getSimpleStationnementsByIdVoiture();
        $stationnement->suppressionStationnement();

        $voiture = $instanceVoiture->getSimpleVoiture();
        $instanceVoiture->setUtilisateursId($voiture->getUtilisateursId());
        $instanceVoiture->setModel($voiture->getModel());
        $instanceVoiture->setMarque($voiture->getMarque());
        $instanceVoiture->setMatricule($voiture->getMatricule());
        $instanceVoiture->setTypes($voiture->getTypes());
        $instanceVoiture->setEtat(0);
        $instanceVoiture->setCreatedAt($voiture->getCreatedAt());
        $instanceVoiture->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceVoiture->updateVoiture();

        $instanceHistoriqueStationnement = new HistoriqueStationnement();
        $instanceHistoriqueStationnement->setVoituresId($stationnement->getVoituresId());
        $instanceHistoriqueStationnement->setPlacesId($stationnement->getPlacesId());
        $instanceHistoriqueStationnement->setTarifParkingsId($stationnement->getTarifParkingsId());
        $instanceHistoriqueStationnement->setParametresId($stationnement->getParametresId());
        $instanceHistoriqueStationnement->setDateDebut($stationnement->getDateDebut());
        $instanceHistoriqueStationnement->setHeureDebut($stationnement->getHeureFin());
        $instanceHistoriqueStationnement->setDateFin($stationnement->getDateFin());
        $instanceHistoriqueStationnement->setHeureFin($stationnement->getHeureFin());
        $instanceHistoriqueStationnement->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriqueStationnement->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriqueStationnement->insertionHistoriqueStationnements();

        return redirect()->to(base_url($baseUrl));
    }

    public function exportticket($id)
    {
        $instanceInfosPlace = new InfosPlace();
        $instanceInfosPlace->setStationnementsId($id);
        $infosPlace = $instanceInfosPlace->getSimpleInfosPlace();
        $instanceTarifParking = new TarifParking();
        $instanceTarifParking->setId($infosPlace->getTarifParkingsId());
        $tarifParking = $instanceTarifParking->getSimpleTarifParking();
        $sommeMontantAmendeEnLettre = ChiffreEnLettre::convertirChiffreEnLettre(strval($tarifParking->getMontant()));
        $html = view("pages/frontend/amende/ticket-pdf", compact("infosPlace", "tarifParking", "sommeMontantAmendeEnLettre"));
        $name = "Ticket-".$infosPlace->getNumeroFactureOuTicket();
        $instancePDF = new PDF();
        $instancePDF->generatePDF($html, $name);
    }
}
