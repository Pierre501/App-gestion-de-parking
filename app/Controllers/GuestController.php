<?php

namespace App\Controllers;

use App\Models\Fonction;
use App\Models\HistoriquePortefeuille;
use App\Models\PDF;
use App\Models\PorteFeuille;
use App\Models\Utilisateur;

class GuestController extends BaseController
{
    public function index()
    {
        $title = "Page d'authentification";
        return view('pages/login/login', compact("title"));
    }

    public function pageInscription()
    {
        $title = "Page d'inscription";
        return view("pages/login/register", compact("title"));
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $motDePasse = $this->request->getVar('motdepasse');
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setUsername($username);
        $instanceUtilisateur->setMotdepasse($motDePasse);
        $instanceUtilisateur->setEtat(1);
        if(!$instanceUtilisateur->login())
        {
            return redirect()->to("/")->with("erreur", "Mauvaise email ou mot de passe");
        }
        $session = session();
        $utilisateur = $instanceUtilisateur->getSimpleUtilisateur();
        $session->set("utilisateur", $utilisateur);
        if($utilisateur->getRoles() == 0)
        {
            return redirect()->to(base_url("auth/utilisateurs/accueil"));
        }
        return redirect()->to(base_url("auth/tableau-de-bord"));
    }

    public function register()
    {
        $nom = $this->request->getVar('nom');
        $username = $this->request->getVar('username');
        $motDePasse = $this->request->getVar('motdepasse');

        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setNom(Fonction::formatNom($nom));
        $instanceUtilisateur->setUsername($username);
        $instanceUtilisateur->setMotdepasse($motDePasse);
        $instanceUtilisateur->setEtat(1);
        $instanceUtilisateur->setRoles(0);
        $instanceUtilisateur->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceUtilisateur->setUpdatedAt(date("Y-m-d H:i:s"));
        $verification = $instanceUtilisateur->insertionUtilisateur($this->request->getVar('motdepasseconfirme'));
        if(is_array($verification))
        {
            return redirect()->to(base_url("page-inscription"))->with("errors_register", $verification);
        }

        $instancePortefeuille = new PorteFeuille();
        $instancePortefeuille->setUtilisateursId($instanceUtilisateur->getInsertID());
        $instancePortefeuille->setMontant(0);
        $instancePortefeuille->setMontantDepense(0);
        $instancePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instancePortefeuille->setEtat(1);
        $instancePortefeuille->insertionPortefeuille();

        $instanceHistoriquePortefeuille = new HistoriquePortefeuille();
        $instanceHistoriquePortefeuille->setPortefeuillleId($instancePortefeuille->getInsertID());
        $instanceHistoriquePortefeuille->setCreatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriquePortefeuille->setUpdatedAt(date("Y-m-d H:i:s"));
        $instanceHistoriquePortefeuille->insertionHistoriquePortefeuille();
        $session = session();
        $session->set("utilisateur", $instanceUtilisateur->getSimpleUtilisateur());
        return redirect()->to(base_url("auth/utilisateurs/accueil"));
    }

    public function pageResetPassword()
    {
        $title = "Page de réinitialisation mot de passe";
        return view("pages/login/reset-password", compact("title"));
    }

    public function pdf()
    {
        $instancePDF = new PDF();
        $instancePDF->generatePDF();
    }
}
