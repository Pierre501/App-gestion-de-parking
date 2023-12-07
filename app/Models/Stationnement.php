<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Stationnement extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'stationnements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['voitures_id', 'places_id', 'tarifparkings_id', 'parametres_id', 'datedebut', 'heuredebut', 'datefin', 'heurefin', 'creaded_at', 'updated_at'];

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

    protected $voituresId;
    protected $placesId;
    protected $tarifParkingsId;
    protected $parametresId;
    protected $dateDebut;
    protected $heureDebut;
    protected $dateFin;
    protected $heureFin;

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
    public function setVoituresId($voituresId)
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
     * Get the value of parametresId
     */ 
    public function getParametresId(): int
    {
        return $this->parametresId;
    }

    /**
     * Set the value of parametresId
     *
     * @return  void
     */ 
    public function setParametresId($parametresId): void
    {
        $this->parametresId = $parametresId;
    }

    /**
     * Get the value of dateDebut
     */ 
    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @return  void
     */ 
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * Get the value of heureDebut
     */ 
    public function getHeureDebut(): string
    {
        return $this->heureDebut;
    }

    /**
     * Set the value of heureDebut
     *
     * @return  void
     */ 
    public function setHeureDebut($heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }

    /**
     * Get the value of dateFin
     */ 
    public function getDateFin(): string
    {
        return $this->dateFin;
    }

    /**
     * Set the value of dateFin
     *
     * @return  void
     */ 
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * Get the value of heureFin
     */ 
    public function getHeureFin(): string
    {
        return $this->heureFin;
    }

    /**
     * Set the value of heureFin
     *
     * @return  void
     */ 
    public function setHeureFin($heureFin): void
    {
        $this->heureFin = $heureFin;
    }

    public function getDataStationnement()
    {
        $data['voitures_id'] = $this->getVoituresId();
        $data['places_id'] = $this->getPlacesId();
        $data['tarifparkings_id'] = $this->getTarifParkingsId();
        $data['parametres_id'] = $this->getParametresId();
        $data['datedebut'] = $this->getDateDebut();
        $data['heuredebut'] = $this->getHeureDebut();
        $data['datefin'] = $this->getDateFin();
        $data['heurefin'] = $this->getHeureFin();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionStationnements(): bool
    {
        $dataStationnements = $this->getDataStationnement();
        $retour = $this->insert($dataStationnements);
        return $retour;
    }

    public function suppressionStationnement()
    {
        $this->delete($this->getId());
    }

    public function getLastStationnementsId(): int
    {
        $lastId = 0;
        $sql = "select max(id) as id from stationnements where voitures_id = %d";
        $sql = sprintf($sql, $this->getVoituresId());
        $row = $this->db->query($sql);
        $lastId = $row->getRow()->id;
        return $lastId;
    }

    public function getSimpleStationnementsByIdVoiture(): Stationnement
    {
        $instance = new Stationnement();
        $sql = "select * from stationnements where voitures_id = %d";
        $sql = sprintf($sql, $this->getVoituresId());
        $query = $this->db->query($sql);
        $row = $query->getRow();
        $instance->setId($row->id);
        $instance->setVoituresId($row->voitures_id);
        $instance->setPlacesId($row->places_id);
        $instance->setTarifParkingsId($row->tarifparkings_id);
        $instance->setParametresId($row->parametres_id);
        $instance->setDateDebut($row->datedebut);
        $instance->setHeureDebut($row->heuredebut);
        $instance->setDateFin($row->datefin);
        $instance->setHeureFin($row->heurefin);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }
}
