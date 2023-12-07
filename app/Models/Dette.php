<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Dette extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'dettes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['voitures_id', 'montant', 'created_at', 'updated_at'];

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
    protected $montant;
    
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

    public function getDataDettes(): array
    {
        $data['voitures_id'] = $this->getVoituresId();
        $data['montant'] = $this->getMontant();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionDette(): bool
    {
        $dataDette = $this->getDataDettes();
        return $this->insert($dataDette);
    }

    public function suppressionDette(): bool
    {
        return $this->delete($this->getId());
    }

    public function getSimpleDetteByUtilisateurId($utilisateursId): Dette
    {
        $instance = new Dette();
        $queryBuilder = $this->db->table('dettes');
        $queryBuilder->join("voitures", "dettes.voitures_id = voitures.id");
        $queryBuilder->where("voitures.utilisateurs_id", $utilisateursId);
        $queryBuilder->select("dettes.id, dettes.voitures_id, dettes.montant, dettes.created_at, dettes.updated_at");
        $row = $queryBuilder->get()->getRow();
        $instance->setId($row->id);
        $instance->setVoituresId($row->voitures_id);
        $instance->setMontant($row->montant);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function verificationDetteUtilisateur($utilisateursId): bool
    {
        $verification = false;
        $sql = "select compteur from view_dette where utilisateurs_id = %d";
        $sql = sprintf($sql, $utilisateursId);
        $row = $this->db->query($sql)->getRow();
        if(!empty($row))
        {
            if($row->compteur == 1)
            {
                $verification = true;
            }
        }
        return $verification;
    }

    public function getSommeTotalDette()
    {
        $sommeTotalDette = 0;
        $query = $this->findAll();
        foreach($query as $row)
        {
            $sommeTotalDette += $row->montant;
        }
        return $sommeTotalDette;
    }
}
