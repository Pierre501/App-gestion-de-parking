<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Amende extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'amendes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nomamende', 'tranche', 'montant', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "nomamende" => ["required"],
        "tranche" => ["required"],
        "montant" => ["required"]
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

    protected $nomAmende;
    protected $tranche;
    protected $montant;

    

    /**
     * Get the value of nomAmende
     */ 
    public function getNomAmende(): string
    {
        return $this->nomAmende;
    }

    /**
     * Set the value of nomAmende
     *
     * @return  void
     */ 
    public function setNomAmende($nomAmende): void
    {
        $this->nomAmende = $nomAmende;
    }

    /**
     * Get the value of tranche
     */ 
    public function getTranche(): int
    {
        return $this->tranche;
    }

    /**
     * Set the value of tranche
     *
     * @return  void
     */ 
    public function setTranche($tranche): void
    {
        $this->tranche = $tranche;
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

    public function getDataAmende(): array
    {
        $data['nomamende'] = $this->getNomAmende();
        $data['tranche'] = $this->getTranche();
        $data['montant'] = $this->getMontant();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function updateAmende(): bool
    {
        $dataAmende = $this->getDataAmende();
        return $this->update($this->getId(), $dataAmende);
    }

    public function getSimpleAmende(): Amende
    {
        $instance = new Amende();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setNomAmende($row->nomamende);
        $instance->setTranche($row->tranche);
        $instance->setMontant($row->montant);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }
}
