<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Parking extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'parkings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nomparking', 'lieuparking', 'created_at', 'updated_at'];

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

    protected $nomparking;
    protected $lieuparking;

    

    /**
     * Get the value of nomparking
     */ 
    public function getNomParking(): string
    {
        return $this->nomparking;
    }

    /**
     * Set the value of nomparking
     *
     * @return  void
     */ 
    public function setNomParking($nomparking): void
    {
        $this->nomparking = $nomparking;
    }

    /**
     * Get the value of lieuparking
     */ 
    public function getLieuParking(): string
    {
        return $this->lieuparking;
    }

    /**
     * Set the value of lieuparking
     *
     * @return  void
     */ 
    public function setLieuParking($lieuparking): void
    {
        $this->lieuparking = $lieuparking;
    }

    public function getAllParkings()
    {
        $listeParking = array();
        $query = $this->findAll();
        foreach($query as $row)
        {
            $instance = new Parking();
            $instance->setId($row->id);
            $instance->setNomParking($row->nomparking);
            $instance->setLieuParking($row->lieuparking);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeParking[] = $instance;
        }
        return $listeParking;
    }
}
