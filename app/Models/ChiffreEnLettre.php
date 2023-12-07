<?php

namespace App\Models;


class ChiffreEnLettre
{
    protected static $dix = "dix";
    protected static $cent = "cent";
    protected static $mille = "mille";
    protected static $million = "million";
    protected static $milliard = "milliard";


    public static function getDataChiffreEnLettre(): array
    {
        $dataChiffreEnLettre = array("zéro", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf", "dix", "onze", "douze", "treize", "quatorze", "quinze", "seize", "vingt", "trente", "quarante", "cinquante", "soixante");
        return $dataChiffreEnLettre;
    }

    public static function verificationChiffre(string $chiffreEnLettre, string $caratere): string
    {
        $valeurRetour = $chiffreEnLettre;
        if($chiffreEnLettre == $caratere)
        {
            $valeurRetour = "";
        }
        return $valeurRetour;
    }

    public static function filtreTableau(array $liste, int $increment, int $taille): array
    {
        $data = array();
        for($i = $increment; $i < $taille; $i++)
        {
            $data[] = $liste[$i];
        }
        return $data;
    }

    public static function concantenation(string $chiffre, int $increment, int $taille): string
    {
        $concatenation = "";
        for($i = $increment; $i < $taille; $i++)
        {
            $concatenation .= $chiffre[$i];
        }
        return $concatenation;
    }

    public static function affichage(array $liste): array
    {
        $data = array();
        for($i = 0; $i < count($liste); $i++)
        {
            $data[] = self::convertirChiffreEnLettre($liste[$i]);
        }
        return $data;
    }

    public static function convertirEnTableau(string $chiffre): array
    {
        $data = array();
        for($i = 0; $i < strlen($chiffre); $i++)
        {
            $data[] = $chiffre[$i];
        }
        return $data;
    }

    public static function getValeurChiffreEnLettreEntre17et19(array $data, int $indice): string
    {
        $chiffreEnLettre = "";
        $chiffreEnLettre = self::$dix." ".$data[$indice];
        return $chiffreEnLettre;
    }

    public static function getValeurChiffreEnLettre70Ou80Ou90(int $valeur1, int $valeur2, string $valeur3, array $liste): string
    {
        $chiffreEnLettre = "";
        if($valeur2 == 0)
        {
            if($valeur1 == 8)
            {
                $chiffreEnLettre = $valeur3;
            }
            else if($valeur1 == 7 || $valeur1 == 9)
            {
                $chiffreEnLettre = $valeur3." ".self::$dix;
            }
        }
        else
        {
            $chiffreEnLettre = $valeur3." ".self::getSimpleValeurChiffreEnLettre70Ou80Ou90($valeur1, $valeur2, $liste);
        }
        return $chiffreEnLettre;
    }

    public static function getSimpleValeurChiffreEnLettre70Ou80Ou90(int $valeur1, int $valeur2, array $liste): string
    {
        $chiffreEnLettre = "";
        if($valeur1 == 8)
        {
            $chiffreEnLettre = $liste[$valeur2];
        }
        else if($valeur1 == 7 || $valeur1 == 9)
        {
            if($valeur2 >= 1 && $valeur2 <= 6)
            {
                $chiffreEnLettre = $liste[10+$valeur2];
            }
            else
            {
                $chiffreEnLettre = self::getValeurChiffreEnLettreEntre17et19($liste, $valeur2);
            }
        }
        return $chiffreEnLettre;
    }

    public static function getValeurChiffreEnLettreEntre20Et99(int $valeur1, int $valeur2, array $liste): string
    {
        $chiffreEnLettre = "";
        if($valeur1 == 7)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettre70Ou80Ou90($valeur1, $valeur2, "soixante", $liste);
        }
        else if($valeur1 == 8)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettre70Ou80Ou90($valeur1, $valeur2, "quatre vingt", $liste);
        }
        else if($valeur1 == 9)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettre70Ou80Ou90($valeur1, $valeur2, "quatre vingt", $liste);
        }
        else if($valeur1 >= 2 && $valeur1 <= 6)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettre20Et30Et40Et50Et60($valeur1, $valeur2, $liste);
        }
        return $chiffreEnLettre;
    }

    public static function getValeurChiffreEnLettre20Et30Et40Et50Et60(int $valeur1, int $valeur2, array $liste): string
    {
        $chiffreEnLettre = "";
        $data = self::filtreTableau($liste, 17, count($liste));
        if($valeur2 == 0)
        {
            $chiffreEnLettre = $data[$valeur1-2];
        }
        else
        {
            $chiffreEnLettre = $data[$valeur1-2]." ".$liste[$valeur2];
        }
        return $chiffreEnLettre;
    }

    public static function getValeurChiffreEnLettreEntre17Et99(string $chiffre, array $liste): string
    {
        $chiffreEnLettre = "";
        $chiffreTableau = self::convertirEnTableau($chiffre);
        if(intval($chiffre) >= 17 && intval($chiffre) <= 19)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettreEntre17et19($liste, intval($chiffreTableau[count($chiffreTableau)-1]));
        }
        else if(intval($chiffre) >= 20 && intval($chiffre) <= 99)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettreEntre20Et99(intval($chiffreTableau[count($chiffreTableau)-2]), intval($chiffreTableau[count($chiffreTableau)-1]), $liste);
        }
        return $chiffreEnLettre;
    }

    public static function convertirDeuxChiffreEnLettre(string $chiffre, array $data): string
    {
        $chiffreEnLettre = "";
        if(intval($chiffre) >= 0 && intval($chiffre) <= 16)
        {
            $chiffreEnLettre = $data[intval($chiffre)];
        }
        elseif (intval($chiffre) >= 15)
        {
            $chiffreEnLettre = self::getValeurChiffreEnLettreEntre17Et99($chiffre, $data);
        }
        return $chiffreEnLettre;
    }

    public static function getValeurChiffreEnLettreCentaine(int $valeurChiffre1, array $data): string
    {
        $chiffreEnLettre = "";
        if(intval($valeurChiffre1) == 1)
        {
            $chiffreEnLettre = self::$cent;
        }
        else if(intval($valeurChiffre1) >= 2 && intval($valeurChiffre1) <= 9)
        {
            $chiffreEnLettre = $data[intval($valeurChiffre1)]." ".self::$cent;
        }
        return $chiffreEnLettre;
    }

    public static function convertirCentaineChiffreEnLettre(string $chiffre): string
    {
        $chiffreEnLettre = "";
        $data = self::getDataChiffreEnLettre();
        if(strlen($chiffre) >= 1 && strlen($chiffre) <= 2)
        {
            $chiffreEnLettre = self::convertirDeuxChiffreEnLettre($chiffre, $data);
        }
        else if(strlen($chiffre) == 3)
        {
            $premierChiffre = self::getValeurChiffreEnLettreCentaine(intval(self::concantenation($chiffre, 0, 1)), $data);
            $secondeChiffre = self::convertirDeuxChiffreEnLettre(self::concantenation($chiffre, 1, strlen($chiffre)), $data);
            $chiffreEnLettre = trim($premierChiffre." ".self::verificationChiffre($secondeChiffre, "zéro"));
        }
        return $chiffreEnLettre;
    }

    public static function getValeurGeneriqueChiffreEnLettre(string $chiffre, string $valeur1, string $valeur2): string
    {
        $chiffreEnLettre = "";
        if(intval($chiffre) == 1)
        {
            $chiffreEnLettre = $valeur1;
        }
        else if(intval($chiffre) >= 2 && intval($chiffre) <= 999)
        {
            $chiffreEnLettre = $valeur2." ".$valeur1;
        }
        return $chiffreEnLettre;
    }

    public static function convertirMillierChiffreEnLettre(string $chiffre): string
    {
        $chiffreEnLettre = "";
        if(strlen($chiffre) >= 1 && strlen($chiffre) <= 3)
        {
            $chiffreEnLettre = self::convertirCentaineChiffreEnLettre($chiffre);
        }
        else if(strlen($chiffre) >= 4 && strlen($chiffre) <= 6)
        {
            $valeurPremierChiffre = self::concantenation($chiffre, 0, strlen($chiffre)-3);
            $premierChiffre = self::getValeurGeneriqueChiffreEnLettre($valeurPremierChiffre, self::$mille, self::convertirCentaineChiffreEnLettre($valeurPremierChiffre));
            $valeurSecondeChiffre = self::concantenation($chiffre, strlen($chiffre)-3, strlen($chiffre));
            $secondeChiffre = self::convertirCentaineChiffreEnLettre($valeurSecondeChiffre);
            $chiffreEnLettre = trim($premierChiffre." ".$secondeChiffre);
        }
        return $chiffreEnLettre;
    }

    public static function convertirMillionChiffreEnLettre(string $chiffre): string
    {
        $chiffreEnLettre = "";
        if(strlen($chiffre) >= 1 && strlen($chiffre) <= 6)
        {
            $chiffreEnLettre = self::convertirMillierChiffreEnLettre($chiffre);
        }
        else if(strlen($chiffre) >= 7 && strlen($chiffre) <= 9)
        {
            $valeurPremierChiffre = self::concantenation($chiffre, 0, strlen($chiffre)-6);
            $premierChiffre = self::getValeurGeneriqueChiffreEnLettre($valeurPremierChiffre, self::$million, self::convertirCentaineChiffreEnLettre($valeurPremierChiffre));
            $valeurSecondeChiffre = self::concantenation($chiffre, strlen($chiffre)-6, strlen($chiffre));
            $secondeChiffre = self::convertirMillierChiffreEnLettre($valeurSecondeChiffre);
            $chiffreEnLettre = trim($premierChiffre." ".$secondeChiffre);
        }
        return $chiffreEnLettre;
    }

    public static function convertirMilliardChiffreEnLettre(string $chiffre): string
    {
        $chiffreEnLettre = "Syntax error";
        if(strlen($chiffre) >= 1 && strlen($chiffre) <= 9)
        {
            $chiffreEnLettre = self::convertirMillionChiffreEnLettre($chiffre);
        }
        else if(strlen($chiffre) >= 10 && strlen($chiffre) <= 12)
        {
            $valeurPremierChiffre = self::concantenation($chiffre, 0, strlen($chiffre)-9);
            $premierChiffre = self::getValeurGeneriqueChiffreEnLettre($valeurPremierChiffre, self::$milliard, self::convertirCentaineChiffreEnLettre($valeurPremierChiffre));
            $valeurSecondeChiffre = self::concantenation($chiffre, strlen($chiffre)-9, strlen($chiffre));
            $secondeChiffre = self::convertirMillionChiffreEnLettre($valeurSecondeChiffre);
            $chiffreEnLettre = trim($premierChiffre." ".$secondeChiffre);
        }
        return $chiffreEnLettre;
    }

    public static function convertirChiffreEnLettre(string $chiffre): string
    {
        $chiffreEnLettre = self::convertirMilliardChiffreEnLettre($chiffre);
        return ucfirst($chiffreEnLettre);
    }
}