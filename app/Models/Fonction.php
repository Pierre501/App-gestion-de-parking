<?php

namespace App\Models;

class Fonction
{
    public static function getValeurDate($createdAt): string
    {
        $date = "";
        $listeCreatedAt = explode(" ", $createdAt);
        $listeDate = explode("-", $listeCreatedAt[0]);
        $date = $listeDate[count($listeDate)-1]."/".$listeDate[count($listeDate)-2]."/".$listeDate[count($listeDate)-3];
        return $date;
    }

    public static function getValeurHeure($createdAt): string
    {
        $heure = "";
        $listeCreatedAt = explode(" ", $createdAt);
        $heure = $listeCreatedAt[count($listeCreatedAt)-1];
        return $heure;
    }

    public static function varificationNunmero($numero): string
    {
        $retour = "";
        if($numero >= 1 && $numero <= 9)
        {
            $retour = "0".strval($numero);
        }
        else
        {
            $retour = strval($numero);
        }
        return $retour;
    }

    public static function generateNumero($nombre, $numero): array
    {
        $listeNumero = array();
        $taille = $nombre + $numero;
        for($i = $numero; $i < $taille; $i++)
        {
            $listeNumero[] = self::varificationNunmero($i);
        }
        return $listeNumero;
    }

    public static function formatHeure($heure): string
    {
        $heureFormat = "";
        $listeHeure = explode(":", $heure);
        if(intval($listeHeure[0]) == 0)
        {
            $heureFormat = $listeHeure[1]." min";
        }
        else
        {
            if(intval($listeHeure[1]) == 0)
            {
                $heureFormat = $listeHeure[0]." h";
            }
            else
            {
                $heureFormat = $listeHeure[0]." h ".$listeHeure[1]." min";
            }
        }
        return $heureFormat;
    }

    public static function generateNom($nom): string
    {
        $retour = "";
        $listeNom = explode(" ", $nom);
        $increment = intval($listeNom[count($listeNom)-1]) + 1;
        $retour = $listeNom[0]." ".$increment;
        return $retour;
    }

    public static function arrandissementValuer($valeur)
    {
        $reste = 0;
        $resteStr = strval($valeur);
        $tabReste = explode('.',$resteStr);
        if(count($tabReste) == 1)
        {
            $reste = intval($tabReste[0]);
        }
        else
        {
            $reste = intval($tabReste[0]) + 1;
        }
        return $reste;
    }

    public static function sommeDelais($reste, $amende)
    {
       $retour = $amende;
        if($reste >= 2)
        {
            for($i = 2; $i <= $reste; $i++)
            {
                $retour = $amende * 2;
                $amende = $retour;
            }
        }
        return $retour;
    }

    public static function generateDesignation($rang): string
    {
        $rangDesignation = "";
        $texte = "tranche d'une amende";
        if($rang == 1)
        {
            $rangDesignation = "1ère ".$texte;
        }
        else
        {
            $rangDesignation = $rang."ème ".$texte;
        }
        return $rangDesignation;
    }

    public static function multiplication($montant, $valeur1, $valeur2): int
    {
        $valeur = 0;
        if($valeur2 == 1)
        {
            $valeur = $montant;
        }
        else
        {
            $valeur = $montant *$valeur1;
        }
        return $valeur;
    }

    public static function addition($valeur1, $valeur2, $valeur3): int
    {
        $valeur = 0;
        if($valeur3 == 1)
        {
            $valeur = $valeur1;
        }
        else
        {
            $valeur = $valeur1 + $valeur2;
        }
        return $valeur;
    }

    public static function calculePourcentageStr($valeur1, $valeur2): string
    {
        $resultat = 0;
        if($valeur1 >= 1)
        {
            $resultat = 100 * $valeur2 / $valeur1;
        }
        return number_format($resultat, 2);
    }

    public static function generateNumeroFacture($numero): string
    {
        $numeroFacture = "";
        $listeNumero = array("00000", "0000", "000", "00", "0");
        $indiceNumero = strlen($numero) - 1;
        $numeroFacture = $listeNumero[$indiceNumero].$numero;
        return $numeroFacture;
    }

    public static function permitationTableau($liste, $taille): array
    {
        $listePermitation = array();
        for($i = 0; $i < $taille; $i++)
        {
            $listePermitation[] = $liste[$i];
        }
        return $listePermitation;
    }

    public static function getListeCouleurs($liste, $taille)
    {
        $listeCouleur = null;
        if($taille <= count($liste))
        {
            $listeCouleur = self::permitationTableau($liste, $taille);
        }
        else
        {
            $listeCouleur1 = self::permitationTableau($liste, count($liste));
            $listeCouleur2 = self::permitationTableau($liste, $taille - count($liste));
            $listeCouleur = array_merge($listeCouleur1, $listeCouleur2);
        }
        return $listeCouleur;
    }

    public static function concatenation($liste): string
    {
        $mot = "";
        array_shift($liste);
        if(count($liste) > 1)
        {
            if(count($liste) == 1)
            {
                $mot = $liste[0];
            }
            else
            {
                for($i = 1; $i < count($liste); $i++)
                {
                    $mot .= " ".$liste[$i];
                }
            }
        }
        return $mot;
    }

    public static function formatNom($nom): string
    {
        $nomFormatter = "";
        $listeNom = explode(" ", $nom);
        $nomFormatter = strtoupper($listeNom[0])." ".ucwords(self::concatenation($listeNom));
        return $nomFormatter;
    }
}