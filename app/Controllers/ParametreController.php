<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Amende;
use App\Models\Parametre;
use App\Models\Utilisateur;

class ParametreController extends BaseController
{
    public function index()
    {
        $title = "Page paramètre";
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        return view("pages/backend/parametre/parametre", compact("title", "parametre", "amende"));
    }

    public function modification()
    {
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        if($this->request->getVar("type_parametre") == "Normale")
        {
            $instanceParametre->setDateParametre($parametre->getDateParametre());
            $instanceParametre->setHeureParametre($parametre->getHeureParametre());
            $instanceParametre->setOptions($this->request->getVar("type_parametre"));
        }
        else
        {
            $instanceParametre->setDateParametre($this->request->getVar("date_parametre"));
            $instanceParametre->setHeureParametre($this->request->getVar("heure_parametre"));
            $instanceParametre->setOptions($this->request->getVar("type_parametre"));
        }
        $instanceParametre->setCreatedAt($parametre->getCreatedAt());
        $instanceParametre->setUpdatedAt(date('Y-m-d H:i:s'));
        $instanceParametre->updateParametre();
        return redirect()->to("auth/parametres");
    }

    public function profile()
    {
        $title = "Page profile";
        return view("pages/frontend/parametre/profile", compact("title"));
    }

    public function modificationProfile()
    {
        $session = session();
        $fullName = strtoupper($this->request->getVar("nom"))." ".ucwords($this->request->getVar("prenom"));
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        $instanceUtilisateur->setNom($fullName);
        $instanceUtilisateur->setUsername($session->get("utilisateur")->getUsername());
        $instanceUtilisateur->setMotdepasse($session->get("utilisateur")->getMotdepasse());
        $instanceUtilisateur->setEtat($session->get("utilisateur")->getEtat());
        $instanceUtilisateur->setRoles($session->get("utilisateur")->getRoles());
        $instanceUtilisateur->setCreatedAt($session->get("utilisateur")->getCreatedAt());
        $instanceUtilisateur->setUpdatedAt(date('Y-m-d H:i:s'));
        if(is_array($instanceUtilisateur->updateUtilisateur()))
        {
            $errors = $instanceUtilisateur->updateUtilisateur();
            return redirect()->to(base_url("auth/parametres/profile"))->with("errors_profiles", $errors);
        }
        $session->set("utilisateur", $instanceUtilisateur);
        return redirect()->to("auth/parametres/profile");
    }

    public function modificationMotDePasse()
    {
        $session = session();
        if(!password_verify($this->request->getVar("ancien_motdepasse"), $session->get("utilisateur")->getMotdepasse()))
        {
            if(!$session->get("utilisateur")->isAdministrateur())
            {
                return redirect()->to(base_url("auth/parametres/page-modification-mot-de-passe"))->with("error_password", "Ancien mot de passe incorrect");
            }
            return redirect()->to(base_url("auth/parametres"))->with("error_password", "Ancien mot de passe incorrect");
        }
        $instanceUtilisateur = new Utilisateur();
        $instanceUtilisateur->setId($session->get("utilisateur")->getId());
        $instanceUtilisateur->setNom($session->get("utilisateur")->getNom());
        $instanceUtilisateur->setUsername($session->get("utilisateur")->getUsername());
        $instanceUtilisateur->setMotdepasse($this->request->getVar("nouveau_motdepasse"));
        $instanceUtilisateur->setEtat($session->get("utilisateur")->getEtat());
        $instanceUtilisateur->setRoles($session->get("utilisateur")->getRoles());
        $instanceUtilisateur->setCreatedAt($session->get("utilisateur")->getCreatedAt());
        $instanceUtilisateur->setUpdatedAt(date('Y-m-d H:i:s'));
        if(is_array($instanceUtilisateur->updateMotDePasse($this->request->getVar("confirme_motdepasse"))))
        {
            $errors = $instanceUtilisateur->updateMotDePasse($this->request->getVar("confirme_motdepasse"));
            if(!$session->get("utilisateur")->isAdministrateur())
            {
                return redirect()->to(base_url("auth/parametres/page-modification-mot-de-passe"))->with("errors_passwords", $errors);
            }
            return redirect()->to(base_url("auth/parametres"))->with("errors_passwords", $errors);
        }
        $session->set("utilisateur", $instanceUtilisateur);
        if(!$session->get("utilisateur")->isAdministrateur())
        {
            return redirect()->to(base_url("auth/parametres/page-modification-mot-de-passe"))->with("success_password", "Votre mot de passe est modifié");
        }
        return redirect()->to(base_url("auth/parametres"))->with("success_password", "Votre mot de passe est modifié");
    }

    public function motdepasse()
    {
        $title = "Page modification mot de passe";
        return view("pages/frontend/parametre/parametre", compact("title"));
    }

    public function modificationAmende()
    {
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        $instanceAmende->setNomAmende($amende->getNomAmende());
        $instanceAmende->setTranche($this->request->getVar("tranche"));
        $instanceAmende->setMontant($this->request->getVar("montant"));
        $instanceAmende->setCreatedAt($amende->getCreatedAt());
        $instanceAmende->setUpdatedAt(date("Y-m-d H:i:s"));
        if(!$instanceAmende->updateAmende())
        {
            $errors = $instanceAmende->errors();
            return redirect()->to(base_url("auth/parametres"))->with("amende_errors", $errors);
        }
        return redirect()->to(base_url("auth/parametres"));
    }
}
