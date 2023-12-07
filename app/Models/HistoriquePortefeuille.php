<?php

namespace App\Models;


class HistoriquePortefeuille extends PorteFeuille
{
    protected $DBGroup          = 'default';
    protected $table            = 'historique_portefeuilles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['portefeuilles_id', 'created_at', 'updated_at'];

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

    protected $portefeuillleId;

    /**
     * Get the value of portefeuillleId
     */ 
    public function getPortefeuillleId(): int
    {
        return $this->portefeuillleId;
    }

    /**
     * Set the value of portefeuillleId
     *
     * @return  void
     */ 
    public function setPortefeuillleId($portefeuillleId): void
    {
        $this->portefeuillleId = $portefeuillleId;
    }

    public function getDataHistoriquePortefeuille()
    {
        $data['portefeuilles_id'] = $this->getPortefeuillleId();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function getFullDataHistoriquePortefeuille()
    {
        $data['id'] = $this->getId();
        $data['montant'] = $this->getMontant();
        $data['montantdepense'] = $this->getMontantDepense();
        $data['etat'] = $this->getEtat();
        $data['portefeuilles_id'] = $this->getPortefeuillleId();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionHistoriquePortefeuille(): bool
    {
        $dataHistoriquePortefeuille = $this->getDataHistoriquePortefeuille();
        $retour = $this->insert($dataHistoriquePortefeuille);
        return $retour;
    }

    public function suppressionHistoriquePortefeuille()
    {
        $this->delete($this->getId());
    }

    public function getAllHistoriquePortefeuilleByIdUtilisateurs()
    {
        $listeHistoriquePortefeuille = array();
        $queryBuilder = $this->db->table("portefeuilles");
        $queryBuilder->join("historique_portefeuilles", "portefeuilles.id = historique_portefeuilles.portefeuilles_id");
        $queryBuilder->select("portefeuilles.utilisateurs_id, portefeuilles.montant, portefeuilles.montantdepense, portefeuilles.etat, historique_portefeuilles.id, historique_portefeuilles.portefeuilles_id, historique_portefeuilles.created_at, historique_portefeuilles.updated_at");
        $queryBuilder->where("portefeuilles.utilisateurs_id", $this->getUtilisateursId());
        $queryBuilder->orderBy("created_at", "desc"); 
        foreach($queryBuilder->get()->getResult() as $row)
        {
            $instance = new HistoriquePortefeuille();
            $instance->setId($row->id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setPortefeuillleId($row->portefeuilles_id);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeHistoriquePortefeuille[] = $instance;
        }
        return $listeHistoriquePortefeuille;
    }

    public function getSimpleHistoriquePortefeuille(): HistoriquePortefeuille
    {
        $instance = new HistoriquePortefeuille();
        $queryBuilder = $this->db->table("portefeuilles");
        $queryBuilder->join("historique_portefeuilles", "portefeuilles.id = historique_portefeuilles.portefeuilles_id");
        $queryBuilder->select("portefeuilles.utilisateurs_id, portefeuilles.montant, portefeuilles.montantdepense, portefeuilles.etat, historique_portefeuilles.id, historique_portefeuilles.portefeuilles_id, historique_portefeuilles.created_at, historique_portefeuilles.updated_at");
        $queryBuilder->where("historique_portefeuilles.id", $this->getId());
        foreach($queryBuilder->get()->getResult() as $row)
        {
            $instance->setId($row->id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setPortefeuillleId($row->portefeuilles_id);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
        }
        return $instance;
    }
}
