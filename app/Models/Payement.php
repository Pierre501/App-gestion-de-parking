<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Payement extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'payements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['utilisateurs_id', 'tarifparkings_id', 'places_id', 'montant', 'motif', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $utilisateursId;
    protected $tarifParkingId;
    protected $placesId;
    protected $montant;
    protected $motif;
    

    /**
     * Get the value of utilisateursId
     */ 
    public function getUtilisateursId(): int
    {
        return $this->utilisateursId;
    }

    /**
     * Set the value of utilisateursId
     *
     * @return  void
     */ 
    public function setUtilisateursId($utilisateursId): void
    {
        $this->utilisateursId = $utilisateursId;
    }

    /**
     * Get the value of tarifParkingId
     */ 
    public function getTarifParkingId(): int
    {
        return $this->tarifParkingId;
    }

    /**
     * Set the value of tarifParkingId
     *
     * @return  void
     */ 
    public function setTarifParkingId($tarifParkingId): void
    {
        $this->tarifParkingId = $tarifParkingId;
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
     * Get the value of montant
     */ 
    public function getMontant(): int|float
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  void
     */ 
    public function setMontant($montant): void
    {
        $this->montant = $montant;
    }

    /**
     * Get the value of motif
     */ 
    public function getMotif(): string
    {
        return $this->motif;
    }

    /**
     * Set the value of motif
     *
     * @return  void
     */ 
    public function setMotif($motif): void
    {
        $this->motif = $motif;
    }

    public function getDataPayement(): array
    {
        $data['utilisateurs_id'] = $this->getUtilisateursId();
        $data['tarifparkings_id'] = $this->getTarifParkingId();
        $data['places_id'] = $this->getPlacesId();
        $data['montant'] = $this->getMontant();
        $data['motif'] = $this->getMotif();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionPayement(): bool
    {
        $dataPayement = $this->getDataPayement();
        $retour = $this->insert($dataPayement);
        return $retour;
    }

    public function getChiffreAffaireMensuelle($dateDebutDuMois, $dateFinDuMois): int|float
    {
        $chiffreAffaireMensuelle = 0;
        $sql = "select sum(montant) as montant from payements where date(created_at) between %s and %s";
        $sql = sprintf($sql, $this->db->escape($dateDebutDuMois), $this->db->escape($dateFinDuMois));
        $row = $this->db->query($sql);
        if(!empty($row->getRow()->montant))
        {
            $chiffreAffaireMensuelle = $row->getRow()->montant;
        }
        return $chiffreAffaireMensuelle;
    }

    public function getChiffreAffaireAnnuelle($dateDebutAnnee, $dateFinAnnee): int|float
    {
        $chiffreAffaireAnnuelle = 0;
        $sql = "select sum(montant) as montant from payements where date(created_at) between %s and %s";
        $sql = sprintf($sql, $this->db->escape($dateDebutAnnee), $this->db->escape($dateFinAnnee));
        $row = $this->db->query($sql);
        if(!empty($row->getRow()->montant))
        {
            $chiffreAffaireAnnuelle = $row->getRow()->montant;
        }
        return $chiffreAffaireAnnuelle;
    }

    public function getMontantAmendePaye($dateDebutDuMois, $dateFinDuMois): int|float
    {
        $totalMontantAmendePaye = 0;
        $sql = "select sum(montant) as montant from payements where motif = %s and date(created_at) between %s and %s group by motif";
        $sql = sprintf($sql, $this->db->escape($this->getMotif()), $this->db->escape($dateDebutDuMois), $this->db->escape($dateFinDuMois));
        $row = $this->db->query($sql);
        if(!empty($row->getRow()->montant))
        {
            $totalMontantAmendePaye = $row->getRow()->montant;
        }
        return $totalMontantAmendePaye;
    }

    public function getAllDataStatiqueChiffreAffaireMensuelle($annee): array
    {
        $data = array();
        $instanceDate = new Date();
        $listeDateDebutEtFinAnnee = $instanceDate->getDateDebutEtFinAnnee($annee);
        $chiffreAffaireAnnuelle = $this->getChiffreAffaireAnnuelle($listeDateDebutEtFinAnnee[0], $listeDateDebutEtFinAnnee[1]);
        $listeDebutDuMois = $instanceDate->getAllDebutDuMois($annee);
        $listeFinDuMois = $instanceDate->getAllFinDuMois($annee);
        for($i = 0; $i < count($listeDebutDuMois); $i++)
        {
            $data[] = floatval(Fonction::calculePourcentageStr($chiffreAffaireAnnuelle, $this->getChiffreAffaireMensuelle($listeDebutDuMois[$i], $listeFinDuMois[$i])));
        }
        return $data;
    }
}
