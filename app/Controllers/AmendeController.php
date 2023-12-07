<?php

namespace App\Controllers;

use App\Models\Amende;
use App\Models\Voiture;
use App\Models\InfosPlace;
use App\Models\Utilisateur;
use App\Models\PorteFeuille;
use App\Controllers\BaseController;
use App\Models\ChiffreEnLettre;
use App\Models\Dette;
use App\Models\HistoriqueStationnement;
use App\Models\Payement;
use App\Models\PDF;
use App\Models\Stationnement;

class AmendeController extends BaseController
{
    public function index()
    {
        $title = "Information sur l'amende";
        $session = session();
        $instanceInfosPlace = new InfosPlace();
        $instanceInfosPlace->setUtlisateursId($session->get("utilisateur")->getId());
        $listeInfosPlace = $instanceInfosPlace->getAllInfosPlaceByUtilisateursId("En infraction");
        return view("pages/frontend/amende/amende", compact("title", "listeInfosPlace"));
    }

    public function facture($id)
    {
        $title = "Facture d'une amende";
        $session = session();
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        $instanceInfosPlace = new InfosPlace();
        $instanceInfosPlace->setUtlisateursId($session->get("utilisateur")->getId());
        $instanceInfosPlace->setVoituresId($id);
        $infosPlace = $instanceInfosPlace->getSimpleInfosPlaceByVoituresId("En infraction");
        $listeDetailsAmende = $infosPlace->getAllValeurDetailsAmende();
        $sommeMontantAmendeEnLettre = ChiffreEnLettre::convertirChiffreEnLettre(strval($infosPlace->getMontantAmende()));
        return view("pages/frontend/amende/facture", compact("title", "amende", "infosPlace", "listeDetailsAmende", "sommeMontantAmendeEnLettre"));
    }

    public function exportfacture($id)
    {
        $session = session();
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        $instanceInfosPlace = new InfosPlace();
        $instanceInfosPlace->setUtlisateursId($session->get("utilisateur")->getId());
        $instanceInfosPlace->setVoituresId($id);
        $infosPlace = $instanceInfosPlace->getSimpleInfosPlaceByVoituresId("En infraction");
        $listeDetailsAmende = $infosPlace->getAllValeurDetailsAmende();
        $sommeMontantAmendeEnLettre = ChiffreEnLettre::convertirChiffreEnLettre(strval($infosPlace->getMontantAmende()));
        $html = view("pages/frontend/amende/facture-pdf", compact("amende", "infosPlace", "listeDetailsAmende", "sommeMontantAmendeEnLettre"));
        $name = "Facture-".$infosPlace->getNumeroFactureOuTicket();
        $instancePDF = new PDF();
        $instancePDF->generatePDF($html, $name);
    }

    public function payement($id)
    {
        $session = session();
        $instanceInfosPlace = new InfosPlace();
        $instanceInfosPlace->setUtlisateursId($session->get("utilisateur")->getId());
        $instanceInfosPlace->setVoituresId($id);
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        $infosPlace = $instanceInfosPlace->getSimpleInfosPlaceByVoituresId("En infraction");

        if($instanceUtilisateur->getSolde() < $infosPlace->getMontantAmende())
        {
            $error = "Votre solde est insuffisant pour effectué cette opération. Veuillez récharger votre portefeuille s'il vous plait!";
            return redirect()->to("auth/amende/facture/".$id)->with("errorPayement", $error);
        }

        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePortefeuille->setMontant(0);
        $instancePortefeuille->setMontantDepense($infosPlace->getMontantAmende());
        $instancePortefeuille->setEtat(1);
        $instancePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->insertionPortefeuille();

        $instancePayement = new Payement();
        $instancePayement->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePayement->setTarifParkingId($infosPlace->getTarifParkingsId());
        $instancePayement->setPlacesId($infosPlace->getPlacesId());
        $instancePayement->setMontant($infosPlace->getMontantAmende());
        $instancePayement->setMotif("Paiement d'une amende sur un parking");
        $instancePayement->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePayement->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePayement->insertionPayement();

        $instanceVoiture = new Voiture();
        $instanceVoiture->setId($infosPlace->getVoituresId());
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

        $instanceStationnement = new Stationnement();
        $instanceStationnement->setId($infosPlace->getStationnementsId());
        $instanceStationnement->suppressionStationnement();

        return redirect()->to("auth/amende")->with("successPayement", "Votre payement est bien effectué");
    }

    public function payementdette()
    {
        $session = session();
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        $instanceDette = new Dette();
        $dette = $instanceDette->getSimpleDetteByUtilisateurId($session->get("utilisateur")->getId());

        if($instanceUtilisateur->getSolde() < $dette->getMontant())
        {
            $error = "Votre solde est insuffisant pour effectué cette opération. Veuillez récharger votre portefeuille s'il vous plait!";
            return redirect()->to(base_url("auth/utilisateurs/accueil"))->with("error_dette", $error);
        }

        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePortefeuille->setMontant(0);
        $instancePortefeuille->setMontantDepense($dette->getMontant());
        $instancePortefeuille->setEtat(1);
        $instancePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->insertionPortefeuille();

        $instanceHistoriqueStationnement = new HistoriqueStationnement();
        $instanceHistoriqueStationnement->setVoituresId($dette->getVoituresId());
        $historiqueStationnement = $instanceHistoriqueStationnement->getSimpleHistoriqueStationnementByVoituresId();

        $instancePayement = new Payement();
        $instancePayement->setUtilisateursId($session->get("utilisateur")->getId());
        $instancePayement->setTarifParkingId($historiqueStationnement->getTarifParkingsId());
        $instancePayement->setPlacesId($historiqueStationnement->getPlacesId());
        $instancePayement->setMontant($dette->getMontant());
        $instancePayement->setMotif("Paiement d'une amende sur un parking");
        $instancePayement->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePayement->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePayement->insertionPayement();

        $dette->suppressionDette();

        return redirect()->to(base_url("auth/utilisateurs/accueil"));
    }
}
