<?php

namespace App\Models;


class Heure extends Date
{

    protected $heure;
    protected $minute;
    protected $seconde;
    

    /**
     * Get the value of heure
     */ 
    public function getHeure(): int
    {
        return $this->heure;
    }

    /**
     * Set the value of heure
     *
     * @return  void
     */ 
    public function setHeure($heure): void
    {
        $this->heure = intval($heure);
    }

    /**
     * Get the value of minute
     */ 
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * Set the value of minute
     *
     * @return  void
     */ 
    public function setMinute($minute): void
    {
        $this->minute = intval($minute);
    }

    /**
     * Get the value of seconde
     */ 
    public function getSeconde(): int
    {
        return $this->seconde;
    }

    /**
     * Set the value of seconde
     *
     * @return  void
     */ 
    public function setSeconde($seconde): void
    {
        $this->seconde = intval($seconde);
    }

    public function heureFormate()
    {
        $heure = strval($this->getHeure()).":".strval($this->getMinute()).":".strval($this->getSeconde());
        return $heure;
    }

    public function formatHeure($heure)
    {
        $tabHeure = explode(':', $heure);
        $formatHeure = new Heure();
        $formatHeure->setHeure($tabHeure[0]);
        $formatHeure->setMinute($tabHeure[1]);
        $formatHeure->setSeconde($tabHeure[2]);
        return $formatHeure;
    }

    public function getSommeHeure($heureDebut, $heureTarif)
    {
        $instanceHeureDebut = $this->formatHeure($heureDebut);
        $instanceHeureTarif = $this->formatHeure($heureTarif);
        $instanceHeure = new Heure();
        $instanceHeure->setHeure($instanceHeureDebut->getHeure() + $instanceHeureTarif->getHeure());
        $instanceHeure->setMinute($instanceHeureDebut->getMinute() + $instanceHeureTarif->getMinute());
        $instanceHeure->setSeconde($instanceHeureDebut->getSeconde() + $instanceHeureTarif->getSeconde());
        return $instanceHeure;
    }

    public function convertierHeureEnMinute()
    {
        $heure = abs($this->getHeure()) * 60;
        $minute = $this->getMinute();
        $minuteFin = $heure + $minute;
        return $minuteFin;
    }

    public function getValeurSeconde(): array
    {
        $listeSeconde = array();
        if($this->getSeconde() >= 0 && $this->getSeconde() <= 59)
        {
            $listeSeconde[] = $this->getSeconde();
            $listeSeconde[] = 0;
        }
        else
        {
            $listeSeconde[] = $this->getSeconde() - 60;
            $listeSeconde[] = 1;
        }
        return $listeSeconde;
    }

    public function getValeurMinute(): array
    {
        $listeMinute = array();
        $listeSeconde = $this->getValeurSeconde();
        $valeurMinute = $this->getMinute() + $listeSeconde[count($listeSeconde)-1];
        if($valeurMinute >= 0 && $valeurMinute <= 59)
        {
            $listeMinute[] = $valeurMinute;
            $listeMinute[] = 0;
        }
        else
        {
            $listeMinute[] = $valeurMinute - 60;
            $listeMinute[] = 1;
        }
        return $listeMinute;
    }

    public function getValeurHeure(): array
    {
        $listeHeure = array();
        $listeMinute = $this->getValeurMinute();
        $valeurHeure = $this->getHeure() + $listeMinute[count($listeMinute)-1];
        if($valeurHeure >= 0 && $valeurHeure <= 23)
        {
            $listeHeure[] = $valeurHeure;
            $listeHeure[] = 0;
        }
        else
        {
            $listeHeure[] = $valeurHeure - 24;
            $listeHeure[] = 1;
        }
        return $listeHeure;
    }

    public function getValeurJour(): array
    {
        $listeJour = array();
        $listeHeure = $this->getValeurHeure();
        $valeurJour = $this->getJour() + $listeHeure[count($listeHeure)-1];
        $jourFinDuMois = $this->getJourFinDuMois($this->getMois(), $this->getAnnee());
        if($valeurJour >= 1 && $valeurJour <= $jourFinDuMois)
        {
            $listeJour[] = $valeurJour;
            $listeJour[] = 0;
        }
        else
        {
            $listeJour[] = $valeurJour - $jourFinDuMois;
            $listeJour[] = 1;   
        }
        return $listeJour;
    }

    public function getValeurMois(): array
    {
        $listeMois = array();
        $listeJour = $this->getValeurJour();
        $valeurMois = $this->getMois() + $listeJour[count($listeJour)-1];
        if($valeurMois >= 1 && $valeurMois <= 12)
        {
            $listeMois[] = $valeurMois;
            $listeMois[] = 0;
        }
        else
        {
            $listeMois[] = $valeurMois - 12;
            $listeMois[] = 1;
        }
        return $listeMois;
    }

    public function getValeurAnnee(): int
    {
        $annee = 0;
        $listeMois = $this->getValeurMois();
        $annee = $this->getAnnee() + $listeMois[count($listeMois)-1];
        return $annee;
    }

    public function getDateFin(): string
    {
        $dateFin = "";
        $annee = $this->getValeurAnnee();
        $listeMois = $this->getValeurMois();
        $listeJour = $this->getValeurJour();
        $instanceHeure = new Heure();
        $instanceHeure->setAnnee($annee);
        $instanceHeure->setMois($listeMois[0]);
        $instanceHeure->setJour($listeJour[0]);
        $dateFin = $instanceHeure->formatDate();
        return $dateFin;
    }

    public function getHeureFin(): string
    {
        $heureFin = "";
        $listeHeure = $this->getValeurHeure();
        $listeMinute = $this->getValeurMinute();
        $listeSeconde = $this->getValeurSeconde();
        $instanceHeure = new Heure();
        $instanceHeure->setHeure($listeHeure[0]);
        $instanceHeure->setMinute($listeMinute[0]);
        $instanceHeure->setSeconde($listeSeconde[0]);
        $heureFin = $instanceHeure->heureFormate();
        return $heureFin;
    }

    public function getCalculeValeurSeconde($secondeDebut, $secondeFin): array
    {
        $listeSeconde = array();
        if($secondeDebut < $secondeFin)
        {
            $listeSeconde[] = 60 + $secondeDebut - $secondeFin;
            $listeSeconde[] = 1;
        }
        else
        {
            $listeSeconde[] = $secondeDebut - $secondeFin;
            $listeSeconde[] = 0;
        }
        return $listeSeconde;
    }

    public function getCalculeValeurMinute($minuteDebut, $minuteFin): array
    {
        $listeMinute = array();
        if($minuteDebut < $minuteFin)
        {
            $listeMinute[] = 60 + $minuteDebut - $minuteFin;
            $listeMinute[] = 1;
        }
        else
        {
            $listeMinute[] = $minuteDebut - $minuteFin;
            $listeMinute[] = 0;
        }
        return $listeMinute;
    }

    public function getHeureTotalEffraction(Heure $heureDebut, Heure $heureFin): Heure
    {
        $instanceHeure = new Heure();
        $listeSeconde = $this->getCalculeValeurSeconde($heureFin->getSeconde(), $heureDebut->getSeconde());
        $valeurSeconde = $listeSeconde[0];
        $listeMinute = $this->getCalculeValeurMinute($heureFin->getMinute(), $heureDebut->getMinute());
        $valeurMinute = $listeMinute[0] - $listeSeconde[1];
        $valeurHeure = $this->scanneValeurHeure($heureDebut, $heureFin) - $heureDebut->getHeure() - $listeMinute[1];
        $instanceHeure->setHeure($valeurHeure);
        $instanceHeure->setMinute($valeurMinute);
        $instanceHeure->setSeconde($valeurSeconde);
        return $instanceHeure;
    }

    public function scanneValeurHeure(Heure $heureDebut, Heure $heureFin): int
    {
        $valeurHeure = 0;
        if($heureDebut->getHeure() <= $heureFin->getHeure())
        {
            $valeurHeure = $heureFin->getHeure();
        }
        else
        {
            if($heureFin->convertionHeureEnSeconde() <= $heureDebut->convertionHeureEnSeconde())
            {
                $valeurHeure = 24 + $heureFin->getHeure();
            }
        }
        return $valeurHeure;
    }

    public function verificationHeure(Heure $heureDebut, Heure $heureFin): bool
    {
        $verification = false;
        if($heureDebut->convertionHeureEnSeconde() <= $heureFin->convertionHeureEnSeconde())
        {
            $verification = true;
        }
        return $verification;
    }

    public function convertionHeureEnSeconde(): int
    {
        $seconde = 0;
        $valeurHeure = $this->getHeure() * 60 * 60;
        $valeurMinute = $this->getMinute() * 60;
        $valeurSeconde = $this->getSeconde();
        $seconde = $valeurHeure + $valeurMinute + $valeurSeconde;
        return $seconde;
    }

    public function convertionHeureEnMinute(): int
    {
        $minute = 0;
        $valeurJour = $this->getJour() * 24 * 60;
        $valeurHeure = $this->getHeure() * 60;
        $valeurMinute = $this->getMinute();
        $minute = $valeurJour + $valeurHeure + $valeurMinute;
        return $minute;
    }

    public function getValeurJourDiffDate(string $dateDebutStr, string $dateFinStr, Heure $heureDebut, Heure $heureFin): int
    {
        $jour = 0;
        $nbrJour = $this->calculDiffDate($dateDebutStr, $dateFinStr);
        if($nbrJour >= 1)
        {
            $verification = $this->verificationHeure($heureDebut, $heureFin);
            if(!$verification)
            {
                $jour = $nbrJour - 1;
            }
            else
            {
                $jour = $nbrJour;
            }
        }
        return $jour;
    }

    public function getDelaisTotalEffraction(string $dateFinStr, string $dateEncoursStr, Heure $heureFin, Heure $heureEncours): Heure
    {
        $heureTotalEffraction = $this->getHeureTotalEffraction($heureFin, $heureEncours);
        $nbrJours = $this->getValeurJourDiffDate($dateFinStr, $dateEncoursStr, $heureFin, $heureEncours);
        $heureTotalEffraction->setJour($nbrJours);
        return $heureTotalEffraction;
    }

    public function getStrDelaisTotalEffraction(string $dateFinStr, string $dateEncoursStr, Heure $heureFin, Heure $heureEncours): string
    {
        $delais = "";
        $heureTotalEffraction = $this->getDelaisTotalEffraction($dateFinStr, $dateEncoursStr, $heureFin, $heureEncours);
        $delais = $heureTotalEffraction->getFomatDelaisHeure();
        return $delais;
    }

    public function getFomatDelaisHeure(): string
    {
        $delais = "";
        if($this->getJour() >= 1)
        {
            $delais = $this->getJour()."j ".$this->getHeure()."h ".$this->getMinute()."min ".$this->getSeconde()."s";
        }
        else
        {
            $delais = $this->getHeure()."h ".$this->getMinute()."min ".$this->getSeconde()."s";
        }
        return $delais;
    }

    public function getMontantTotalAmande($heureTotalEffraction): int|float
    {
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        $modulo = $heureTotalEffraction->convertionHeureEnMinute() / $amende->getTranche();
        $reste = Fonction::arrandissementValuer($modulo);
        $amendeFinal = Fonction::sommeDelais($reste, $amende->getMontant());
        return $amendeFinal;
    }
}