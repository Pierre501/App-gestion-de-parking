<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class TarifParking extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'tarifparkings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tarif', 'dure', 'montant', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'dure' => 'required',
        'montant' => 'required'
    ];
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


    protected $tarif;
    protected $dure;
    protected $montant;

    /**
     * Get the value of tarif
     */ 
    public function getTarif(): string
    {
        return $this->tarif;
    }

    /**
     * Set the value of tarif
     *
     * @return  void
     */ 
    public function setTarif($tarif): void
    {
        $this->tarif = $tarif;
    }

    /**
     * Get the value of dure
     */ 
    public function getDure(): string
    {
        return $this->dure;
    }

    /**
     * Set the value of dure
     *
     * @return  void
     */ 
    public function setDure($dure): void
    {
        $this->dure = $dure;
    }

    /**
     * Get the value of montant
     */ 
    public function getMontant(): float
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

    public function getSimpleTarifParking(): TarifParking
    {
        $instance = new TarifParking();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setTarif($row->tarif);
        $instance->setDure($row->dure);
        $instance->setMontant($row->montant);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function getAllTarifParking()
    {
        $listeTarifParking = array();
        $query = $this->findAll();
        foreach($query as $row)
        {
            $instance = new TarifParking();
            $instance->setId($row->id);
            $instance->setTarif($row->tarif);
            $instance->setDure($row->dure);
            $instance->setMontant($row->montant);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeTarifParking[] = $instance;
        }
        return $listeTarifParking;
    }

    public function getDataTarifParking()
    {
        $data['tarif'] = $this->getTarif();
        $data['dure'] = $this->getDure();
        $data['montant'] = $this->getMontant();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function getDataTarifParkingById()
    {
        $data['id'] = $this->getId();
        $data['tarif'] = $this->getTarif();
        $data['dure'] = $this->getDure();
        $data['montant'] = $this->getMontant();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionTarifParking(): bool
    {
        $dataTarifParking = $this->getDataTarifParking();
        $retour = $this->insert($dataTarifParking);
        return $retour;
    }

    public function updateTarifParking(): bool
    {
        $dataTarifParking = $this->getDataTarifParking();
        $retour = $this->update($this->getId(), $dataTarifParking);
        return $retour;
    }

    public function suppressionTaridParking()
    {
        $this->delete($this->getId());
    }

    public function getHeureFormat()
    {
        $heure = Fonction::formatHeure($this->getDure());
        return $heure;
    }

    public function getLastTarifParkingId(): int
    {
        $lastId = 0;
        $sql = "select max(id) as id from tarifparkings";
        $row = $this->db->query($sql);
        $lastId = $row->getRow()->id;
        return $lastId;
    }

    public function generateNomTarif(): string
    {
        $nomTarif = "";
        $instance = new TarifParking();
        $instance->setId($this->getLastTarifParkingId());
        $nomTarif = Fonction::generateNom($instance->getSimpleTarifParking()->getTarif());
        return $nomTarif;
    }
}
