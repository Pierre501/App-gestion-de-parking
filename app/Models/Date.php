<?php

namespace App\Models;

use DateTime;

class Date
{
    protected $annee;
    protected $mois;
    protected $jour;

    public function setAnnee($annee): void
    {
        $this->annee = intval($annee);
    }

    public function getAnnee(): int
    {
        return $this->annee;
    }

    public function setMois($mois): void
    {
        $this->mois = intval($mois);
    }

    public function getMois(): int
    {
        return $this->mois;
    }

    public function setJour($jour): void
    {
        $this->jour = intval($jour);
    }

    public function getJour(): int
    {
        return $this->jour;
    }

    public function formatDate()
    {
        $dateStr = $this->getAnnee()."-".$this->getMois()."-".$this->getJour();
        return $dateStr;
    }

    public function formatDateParametre($date)
    {
        $tabDate = explode('-', $date);
        $formatDate = new Date();
        $formatDate->setAnnee($tabDate[0]);
        $formatDate->setMois($tabDate[1]);
        $formatDate->setJour($tabDate[2]);
        return $formatDate;
    }

    public function getDateEncours()
    {
        $dateEncours = date("Y-m-d");
        return $dateEncours;
    }

    public function getJourFinDuMois($moisStr, $anneeEncours)
    {
        $jourFinDuMois = 0;
        $mois = intval($moisStr);
        if($anneeEncours % 4 == 0)
        {
            $listeJourFinDuMois = array("31", "29", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");
            $jourFinDuMois = $listeJourFinDuMois[$mois-1];
        }
        else
        {
            $listeJourFinDuMois = array("31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");
            $jourFinDuMois = $listeJourFinDuMois[$mois-1];
        }
        return $jourFinDuMois;
    }

    public function getDateDebutDuMois($mois, $anneeEncours)
    {
        $dateDebutDuMois = new Date();
        $dateDebutDuMois->setAnnee($anneeEncours);
        $dateDebutDuMois->setMois($mois);
        $dateDebutDuMois->setJour("01");
        return $dateDebutDuMois->formatDate();
    }

    public function getDateFinDuMois($mois, $anneeEncours)
    {
        $dateFinDuMois = new Date();
        $dateFinDuMois->setAnnee($anneeEncours);
        $dateFinDuMois->setMois($mois);
        $dateFinDuMois->setJour($this->getJourFinDuMois($mois, $anneeEncours));    
        return $dateFinDuMois->formatDate();
    }

    public function getDateDebutEtFinDuMois($mois, $anneeEncours)
    {
        $dateDebutEtFinDuMois[] = $this->getDateDebutDuMois($mois, $anneeEncours);
        $dateDebutEtFinDuMois[] = $this->getDateFinDuMois($mois, $anneeEncours);
        return $dateDebutEtFinDuMois;
    }

    public function getDateDebutAnnee($annee)
    {
        $instanceDate = new Date();
        $instanceDate->setAnnee($annee);
        $instanceDate->setMois("01");
        $instanceDate->setJour("01");
        return $instanceDate->formatDate();
    }

    public function getDateFinAnnee($annee)
    {
        $instanceDate = new Date();
        $instanceDate->setAnnee($annee);
        $instanceDate->setMois("12");
        $instanceDate->setJour("31");
        return $instanceDate->formatDate();
    }

    public function getDateDebutEtFinAnnee($annee)
    {
        $dateDebutEtFinAnnee[] = $this->getDateDebutAnnee($annee);
        $dateDebutEtFinAnnee[] = $this->getDateFinAnnee($annee);
        return $dateDebutEtFinAnnee;
    }

    public static function calculDiffDate($dateDebut, $dateFin)
    {
        $nbrJours = 0;
        $firstDate  = new DateTime($dateDebut);
        $secondDate = new DateTime($dateFin);
        $jour = $firstDate->diff($secondDate);
        $nbrJours = abs($jour->days);
        return $nbrJours;
    }

    public function getAllDebutDuMois($annee)
    {
        $listeDebutDuMois = array();
        for($i = 1; $i <= 12; $i++)
        {
            $listeDebutDuMois[] = $this->getDateDebutDuMois(strval($i), $annee);
        }
        return $listeDebutDuMois;
    }

    public function getAllFinDuMois($annee)
    {
        $listeFinDuMois = array();
        for($i = 1; $i <= 12; $i++)
        {
            $listeFinDuMois[] = $this->getDateFinDuMois(strval($i), $annee);
        }
        return $listeFinDuMois;
    }

    public static function getAllListeMois()
    {
        $listeMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        return $listeMois;
    }

    public static function getStrMoisEncours($mois)
    {
        $listeMois = Date::getAllListeMois();
        $moisEncours = $listeMois[intval($mois)-1];
        return $moisEncours;
    }

    public static function formatMoisEncoursStr($moisEncoursStr)
    {
        $moisStr = "de ".$moisEncoursStr;
        if(self::verificationMois($moisEncoursStr))
        {
            $moisStr = "d'".$moisEncoursStr;
        }
        return strtolower($moisStr);
    }

    public static function filtreMois($moisEncours)
    {
        $listeMoisFiltre = array();
        $listeMois = Date::getAllListeMois();
        for($i = 0; $i < count($listeMois); $i++)
        {
            if($listeMois[$i] != $moisEncours)
            {
                $listeMoisFiltre[] = $listeMois[$i];
            }
        }
        return $listeMoisFiltre;
    }

    public static function getIndiceMoisEncours($moisEncours)
    {
        $indice = 0;
        $listeMois = Date::getAllListeMois();
        for($i = 0; $i < count($listeMois); $i++)
        {
            if($listeMois[$i] == $moisEncours)
            {
                $indice = $i;
                break;
            }
        }
        return $indice+1;
    }

    public static function verificationMois($mois)
    {
        $verifier = false;
        if($mois == "Avril" || $mois == "Août" || $mois == "Octobre")
        {
            $verifier = true;
        }
        return $verifier;
    }

    public function verificationFinDuMois($mois, $annee)
    {
        $verification = false;
        $listeFinDuMois = $this->getAllFinDuMois($annee);
        $dateFinDuMois = $this->getDateFinDuMois($mois, $annee);
        foreach($listeFinDuMois as $finDuMois)
        {
            if(date_create($finDuMois) == date_create($dateFinDuMois))
            {
                $verification = true;
            }
        }
        return $verification;
    }
}
