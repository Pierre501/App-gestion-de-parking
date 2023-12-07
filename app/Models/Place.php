<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Place extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'places';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['parkings_id', 'numero', 'created_at', 'updated_at'];

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

    protected $parkingsId;
    protected $numero;
 

    /**
     * Get the value of parkingsId
     */ 
    public function getParkingsId(): int
    {
        return $this->parkingsId;
    }

    /**
     * Set the value of parkingsId
     *
     * @return  void
     */ 
    public function setParkingsId($parkingsId): void
    {
        $this->parkingsId = $parkingsId;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero(): string
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  void
     */ 
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    public function getDataPlaces()
    {
        $data['parkings_id'] = $this->getParkingsId();
        $data['numero'] = $this->getNumero();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function getDataPlacesWithId()
    {
        $data['id'] = $this->getId();
        $data['parkings_id'] = $this->getParkingsId();
        $data['numero'] = $this->getNumero();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionPlaces(): bool
    {
        $dataPlaces = $this->getDataPlaces();
        $retour = $this->insert($dataPlaces);
        return $retour;
    }

    public function suppressionPlaces()
    {
        $this->delete($this->getId());
    }

    public function getLastPlacesId()
    {
        $lastId = 0;
        $sql = "select max(id) as id from places";
        $row = $this->db->query($sql);
        $lastId = $row->getRow()->id;
        return $lastId;
    }

    public function insertionAllPlaces($nombrePlaces)
    {
        $instance = new Place();
        $instance->setId($this->getLastPlacesId());
        $numero = intval($instance->getSimplePlaces()->getNumero()) + 1;
        $listeNumero = Fonction::generateNumero($nombrePlaces, $numero);
        for($i = 0; $i < count($listeNumero); $i++)
        {
            $instance->setParkingsId($this->getParkingsId());
            $instance->setNumero($listeNumero[$i]);
            $instance->setCreatedAt($this->getCreatedAt());
            $instance->setUpdatedAt($this->getUpdatedAt());
            $instance->insertionPlaces();
        }
    }

    public function getSimplePlaces(): Place
    {
        $instance = new Place();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setParkingsId($row->parkings_id);
        $instance->setNumero($row->numero);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function getAllPlaces()
    {
        $listePlaces = array();
        $query = $this->findAll();
        foreach($query as $row)
        {
            $instance = new Place();
            $instance->setId($row->id);
            $instance->setParkingsId($row->parkings_id);
            $instance->setNumero($row->numero);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listePlaces[] = $instance;
        }
        return $listePlaces;
    }

    public function getPlacesIdByNumeroPlace($listePlaces, $numeroPlace): int
    {
        $placesId = 0;
        foreach($listePlaces as $places)
        {
            if($places->getNumero() == $numeroPlace)
            {
                $placesId = $places->getId();
                break;
            }
        }
        return $placesId;
    }
}



