<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use CodeIgniter\Commands\Cache\InfoCache;

class InfosPlace extends BaseModel
{
    protected $voituresId;
    protected $placesId;
    protected $stationnementsId;
    protected $tarifParkingsId;
    protected $utlisateursId;
    protected $model;
    protected $marque;
    protected $matricule;
    protected $type;
    protected $dateDebut;
    protected $heureDebut;
    protected $dateFin;
    protected $heureFin;
    protected $dure;
    protected $delais;
    protected $numero;
    protected $couleur;
    protected $icons;
    protected $etat;
    protected $montantAmende;



   /**
     * Get the value of voituresId
     */ 
    public function getVoituresId(): int
    {
        return $this->voituresId;
    }

    /**
     * Set the value of voituresId
     *
     * @return  void
     */ 
    public function setVoituresId($voituresId): void
    {
        $this->voituresId = $voituresId;
    }

    /**
     * Get the value of placesId
     */ 
    public function getPlacesId(): int
    {
        return $this->placesId;
    }

    /**
     * Set the value of placesId
     *
     * @return  void
     */ 
    public function setPlacesId($placesId): void
    {
        $this->placesId = $placesId;
    }

    /**
     * Get the value of stationnementsId
     */ 
    public function getStationnementsId(): int
    {
        return $this->stationnementsId;
    }

    /**
     * Set the value of stationnementsId
     *
     * @return  void
     */ 
    public function setStationnementsId($stationnementsId): void
    {
        $this->stationnementsId = $stationnementsId;
    }

    /**
     * Get the value of tarifParkingsId
     */ 
    public function getTarifParkingsId(): int
    {
        return $this->tarifParkingsId;
    }

    /**
     * Set the value of tarifParkingsId
     *
     * @return  void
     */ 
    public function setTarifParkingsId($tarifParkingsId): void
    {
        $this->tarifParkingsId = $tarifParkingsId;
    }

    /**
     * Get the value of utlisateursId
     */ 
    public function getUtlisateursId(): int
    {
        return $this->utlisateursId;
    }

    /**
     * Set the value of utlisateursId
     *
     * @return  void
     */ 
    public function setUtlisateursId($utlisateursId): void
    {
        $this->utlisateursId = $utlisateursId;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    public function getMarque()
    {
        return $this->marque;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    public function getMatricule()
    {
        return $this->matricule;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setHeureDebut($heureDebut)
    {
        $this->heureDebut = $heureDebut;
    }

    public function getHeureDebut()
    {
        return $this->heureDebut;
    }

    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    public function getDateFin()
    {
        return $this->dateFin;
    }

    public function setHeureFin($heureFin)
    {
        $this->heureFin = $heureFin;
    }

    public function getHeureFin()
    {
        return $this->heureFin;
    }
    public function setDure($dure)
    {
        $this->dure = $dure;
    }

    public function getDure()
    {
        return $this->dure;
    }

    public function setDelais($delais)
    {
        $this->delais = $delais;
    }

    public function getDelais()
    {
        return $this->delais;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    public function getCouleur()
    {
        return $this->couleur;
    }

    public function setIcons($icons)
    {
        $this->icons = $icons;
    }

    public function getIcons()
    {
        return $this->icons;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setMontantAmende($montantAmende)
    {
        $this->montantAmende = $montantAmende;
    }

    public function getMontantAmende()
    {
        return $this->montantAmende;
    }

    public function getPlacesIdByNumeroPlace()
    {
        $idPlaces = 0;
        $sql = "select id from places where numero = %s";
        $sql = sprintf($sql, $this->db->escape($this->getNumero()));
        $row = $this->db->query($sql);
        $idPlaces = $row->getRow()->id;
        return $idPlaces;
    }

    public function checkProprietaireVoiture($utilisateursId): bool
    {
        $instance = new Voiture();
        $instance->setId($this->getVoituresId());
        $instance->setUtilisateursId($utilisateursId);
        $verification = $instance->verificationProprietaireVoiture();
        return $verification;
    }

    public function getSimpleInfosPlace()
    {
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        $sql = "select * from viewsetatparking where id = %d";
        $sql = sprintf($sql, $this->getStationnementsId());
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $infos = new InfosPlace();
        $infos->setVoituresId($rows['voitures_id']);
        $infos->setPlacesId($rows['places_id']);
        $infos->setStationnementsId($rows['id']);
        $infos->setTarifParkingsId($rows['tarifparkings_id']);
        $infos->setUtlisateursId($rows['utilisateurs_id']);
        $infos->setModel($rows['model']);
        $infos->setMarque($rows['marque']);
        $infos->setMatricule($rows['matricule']);
        $infos->setType($rows['types']);
        $infos->setDateDebut($rows['datedebut']);
        $infos->setHeureDebut($rows['heuredebut']);
        $infos->setDateFin($rows['datefin']);
        $infos->setHeureFin($rows['heurefin']);
        $infos->setDure($rows['dure']);
        $infos->setNumero($rows['numero']);
        if($parametre->getOptions() == "Normale")
        {
            $infos->setEtat($rows['etatencours']);
            $listeParametre = $this->getConditionInfosPlace($rows['etatencours']);
            $infos->setCouleur($listeParametre['couleur']);
            $infos->setIcons($listeParametre['icons']);
        }
        else
        {
            $infos->setEtat($rows['etatparametre']);
            $listeParametre = $this->getConditionInfosPlace($rows['etatparametre']);
            $infos->setCouleur($listeParametre['couleur']);
            $infos->setIcons($listeParametre['icons']);
        }
        return $infos;
    }

    public function getAllInfosPlace()
    {
        $data = array();
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        $instancePlaces = new Place();
        $listePlaces = $instancePlaces->getAllPlaces();
        $sql = "select * from viewsetatparking";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $infos = new InfosPlace();
            $infos->setVoituresId($rows['voitures_id']);
            $infos->setPlacesId($instancePlaces->getPlacesIdByNumeroPlace($listePlaces, $rows['numero']));
            $infos->setStationnementsId($rows['id']);
            $infos->setTarifParkingsId($rows['tarifparkings_id']);
            $infos->setUtlisateursId($rows['utilisateurs_id']);
            $infos->setModel($rows['model']);
            $infos->setMarque($rows['marque']);
            $infos->setMatricule($rows['matricule']);
            $infos->setType($rows['types']);
            $infos->setDateDebut($rows['datedebut']);
            $infos->setHeureDebut($rows['heuredebut']);
            $infos->setDateFin($rows['datefin']);
            $infos->setHeureFin($rows['heurefin']);
            $infos->setDure($rows['dure']);
            $infos->setNumero($rows['numero']);
            if($parametre->getOptions() == "Normale")
            {
                $infos->setEtat($rows['etatencours']);
                $listeParametre = $this->getConditionInfosPlace($rows['etatencours']);
                $infos->setCouleur($listeParametre['couleur']);
                $infos->setIcons($listeParametre['icons']);
                $listeDelaisEtMontantAmende = $this->getValeurDelaisEtMontantAmende($rows['etatencours'], $rows['datefin'], $rows['heurefin']);
                $infos->setDelais($listeDelaisEtMontantAmende['delais']);
                $infos->setMontantAmende($listeDelaisEtMontantAmende['montant']);
            }
            else
            {
                $infos->setEtat($rows['etatparametre']);
                $listeParametre = $this->getConditionInfosPlace($rows['etatparametre']);
                $infos->setCouleur($listeParametre['couleur']);
                $infos->setIcons($listeParametre['icons']);
                $listeDelaisEtMontantAmende = $this->getValeurDelaisEtMontantAmende($rows['etatencours'], $rows['datefin'], $rows['heurefin']);
                $infos->setDelais($listeDelaisEtMontantAmende['delais']);
                $infos->setMontantAmende($listeDelaisEtMontantAmende['montant']);
            }
            $data[] = $infos;
        }
        return $data;
    }

    public function getValeurDelaisEtMontantAmende($etat, $dateFinStr, $heureFinStr): array
    {
        $listeDelaisEtMontantAmende = array();
        if($etat == "En infraction" && !empty($dateFinStr) && !empty($heureFinStr))
        {
            $instanceHeure = new Heure();
            $heureFin = $instanceHeure->formatHeure($heureFinStr);
            $delaisAmende = $this->getDelaisInfraction($dateFinStr, $heureFin);
            $montantAmende = $instanceHeure->getMontantTotalAmande($this->getHeureDelaisInfraction($dateFinStr, $heureFin));
            $listeDelaisEtMontantAmende['delais'] = $delaisAmende;
            $listeDelaisEtMontantAmende['montant'] = $montantAmende;
        }
        else if($etat == "Occupé" && !empty($dateFinStr) && !empty($heureFinStr))
        {
            $instanceHeure = new Heure();
            $heureFin = $instanceHeure->formatHeure($heureFinStr);
            $delaisHeure = $this->getHeureDelaisOccupe($dateFinStr, $heureFin);
            $listeDelaisEtMontantAmende['delais'] = $delaisHeure->getFomatDelaisHeure();
            $listeDelaisEtMontantAmende['montant'] = 0;
        }
        else
        {
            $listeDelaisEtMontantAmende['delais'] = "";
            $listeDelaisEtMontantAmende['montant'] = 0;
        }
        return $listeDelaisEtMontantAmende;
    }

    public function getSQLAllInfosPlaceByUtilisateursId($parametre): string
    {
        $sql = "";
        if($parametre == "Normale")
        {
            $sql = "select * from viewsetatparking where utilisateurs_id = %d and etatencours = %s";
        }
        else
        {
            $sql = "select * from viewsetatparking where utilisateurs_id = %d and etatparametre = %s";
        }
        return $sql;
    }

    public function getConditionInfosPlace($etat): array
    {
        $listeParametre = array();
        if ($etat == "Occupé") 
        {
            $listeParametre['couleur'] = "box bg-warning text-center";
            $listeParametre['icons'] = "mdi mdi-car";
        } 
        else if ($etat == "En infraction") 
        {
            $listeParametre['couleur'] = "box bg-danger text-center";
            $listeParametre['icons'] = "mdi mdi-alert";
        } 
        else 
        {
            $listeParametre['couleur'] = "box bg-success text-center";
            $listeParametre['icons'] = "mdi mdi-road-variant";
        }
        return $listeParametre;
    }

    public function getAllInfosPlaceByUtilisateursId($etats)
    {
        $data = array();
        $instanceHeure = new Heure();
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        $sql = $this->getSQLAllInfosPlaceByUtilisateursId($parametre->getOptions());
        $sql = sprintf($sql, $this->getUtlisateursId(), $this->db->escape($etats));
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $infos = new InfosPlace();
            $infos->setVoituresId($rows['voitures_id']);
            $infos->setPlacesId($rows['places_id']);
            $infos->setStationnementsId($rows['id']);
            $infos->setTarifParkingsId($rows['tarifparkings_id']);
            $infos->setUtlisateursId($rows['utilisateurs_id']);
            $infos->setModel($rows['model']);
            $infos->setMarque($rows['marque']);
            $infos->setMatricule($rows['matricule']);
            $infos->setType($rows['types']);
            $infos->setDateDebut($rows['datedebut']);
            $infos->setHeureDebut($rows['heuredebut']);
            $infos->setDateFin($rows['datefin']);
            $infos->setHeureFin($rows['heurefin']);
            $infos->setDure($rows['dure']);
            $infos->setNumero($rows['numero']);
            if($parametre->getOptions() == "Normale")
            {
                $infos->setEtat($rows['etatencours']);
                $listeParametre = $this->getConditionInfosPlace($rows['etatencours']);
                $infos->setCouleur($listeParametre['couleur']);
                $infos->setIcons($listeParametre['icons']);
            }
            else
            {
                $infos->setEtat($rows['etatparametre']);
                $listeParametre = $this->getConditionInfosPlace($rows['etatparametre']);
                $infos->setCouleur($listeParametre['couleur']);
                $infos->setIcons($listeParametre['icons']);
            }
            $heureFin = $instanceHeure->formatHeure($rows['heurefin']);
            $infos->setDelais($this->getDelaisInfraction($rows['datefin'], $heureFin));
            $infos->setMontantAmende($instanceHeure->getMontantTotalAmande($this->getHeureDelaisInfraction($rows['datefin'], $heureFin)));
            $data[] = $infos;
        }
        return $data;
    }

    public function getValeurDelaisEnMinute(): int
    {
        $minute = 0;
        $instanceHeure = new Heure();
        $heureFin = $instanceHeure->formatHeure($this->getHeureFin());
        $minute = $this->getHeureDelaisInfraction($this->getDateFin(), $heureFin)->convertionHeureEnMinute();
        return $minute;
    }

    public function getSimpleInfosPlaceByVoituresId($etat): InfosPlace|null
    {
        $instanceInfosPlace = null;
        $listeInfosPlace = $this->getAllInfosPlaceByUtilisateursId($etat);
        foreach($listeInfosPlace as $infosPlace)
        {
            if($infosPlace->getVoituresId() == $this->getVoituresId())
            {
                $instanceInfosPlace = $infosPlace;
                break;
            }
        }
        return $instanceInfosPlace;
    }

    public function getDelaisInfraction(string $dateFinStr, Heure $heureFin): string
    {
        $delais = "";
        $instanceHeureEncours = new Heure();
        $instanceHeureEncours->setHeure(date('H'));
        $instanceHeureEncours->setMinute(date('i'));
        $instanceHeureEncours->setSeconde(date('s'));
        $dateEncoursStr = date('Y-m-d');
        $delais = $instanceHeureEncours->getStrDelaisTotalEffraction($dateFinStr, $dateEncoursStr, $heureFin, $instanceHeureEncours);
        return $delais;
    }

    public function getHeureDelaisInfraction(string $dateFinStr, Heure $heureFin): Heure
    {
        $instanceHeureEncours = new Heure();
        $instanceHeureEncours->setHeure(date('H'));
        $instanceHeureEncours->setMinute(date('i'));
        $instanceHeureEncours->setSeconde(date('s'));
        $dateEncoursStr = date('Y-m-d');
        $heure = $instanceHeureEncours->getDelaisTotalEffraction($dateFinStr, $dateEncoursStr, $heureFin, $instanceHeureEncours);
        return $heure;
    }

    public function getHeureDelaisOccupe(string $dateFinStr, Heure $heureFin): Heure
    {
        $heure = "";
        $instanceHeureEncours = new Heure();
        $instanceHeureEncours->setHeure(date('H'));
        $instanceHeureEncours->setMinute(date('i'));
        $instanceHeureEncours->setSeconde(date('s'));
        $dateEncoursStr = date('Y-m-d');
        $heure = $instanceHeureEncours->getDelaisTotalEffraction($dateEncoursStr, $dateFinStr, $instanceHeureEncours, $heureFin);
        return $heure;
    }

    public function getValeurDate($date)
    {
        $date = Fonction::getValeurDate($date);
        return $date;
    }

    public function getAllValeurDetailsAmende(): array
    {
        $detailsAmende = array();
        $instanceAmende = new Amende();
        $instanceAmende->setId(1);
        $amende = $instanceAmende->getSimpleAmende();
        $nombreTranche = Fonction::arrandissementValuer($this->getValeurDelaisEnMinute() / $amende->getTranche());
        $montantAmende = $amende->getMontant();
        $dureTranche = $amende->getTranche();
        for($i = 1; $i < $nombreTranche; $i++)
        {
            $sommeMontant = Fonction::multiplication($montantAmende, 2, $i);
            $sommeDure = Fonction::addition($dureTranche, 60, $i);
            $detailsAmende[] = $this->getValeurDetailsAmende($i, $sommeMontant, $sommeDure);
            $montantAmende = $sommeMontant;
            $dureTranche = $sommeDure;
        }
        return $detailsAmende;
    }

    public function getValeurDetailsAmende($rang, $somme, $dure): array
    {
        $detailsAmende = array();
        $detailsAmende['designation'] = Fonction::generateDesignation($rang);
        $detailsAmende['dure'] = $dure;
        $detailsAmende['prix'] = $somme;
        return $detailsAmende;
    }

    public function compteurEtatInfosPlaces($listeInfosPlace, $etat): int
    {
        $compteur = 0;
        foreach($listeInfosPlace as $infosPlace)
        {
            if($infosPlace->getEtat() == $etat)
            {
                $compteur++;
            }
        }
        return $compteur;
    }

    public function compteurMontantInfaction($listeInfosPlace): int|float
    {
        $totalMontantInfraction = 0;
        foreach($listeInfosPlace as $infosPlace)
        {
            $totalMontantInfraction += $infosPlace->getMontantAmende();
        }
        return $totalMontantInfraction;
    }

    public function getNumeroFactureOuTicket(): string
    {
        $numeroFacture = Fonction::generateNumeroFacture(strval($this->getStationnementsId()));
        return $numeroFacture;
    }

    public function getSimpleMontantAmende(): int|float
    {
        $montantAmende = 0;
        $listeInfosPlace = $this->getAllInfosPlace();
        foreach($listeInfosPlace as $infosPlace)
        {
            if($infosPlace->getEtat() != "Libre")
            {
                if($infosPlace->getVoituresId() == $this->getVoituresId())
                {
                    $montantAmende = $infosPlace->getMontantAmende();
                    break;
                }
            }
        }
        return $montantAmende;
    }
}
