<?php

namespace App\Models;


class PorteFeuille extends Utilisateur
{
    protected $DBGroup          = 'default';
    protected $table            = 'portefeuilles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['utilisateurs_id', 'montant', 'montantdepense', 'etat', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
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


    protected $utilisateursId;
    protected $montant;
    protected $montantDepense;
    protected $etat;

    

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
     * Get the value of montant
     */ 
    public function getMontant(): float|int
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
     * Get the value of montantDepense
     */ 
    public function getMontantDepense(): float|int
    {
        return $this->montantDepense;
    }

    /**
     * Set the value of montantDepense
     *
     * @return  void
     */ 
    public function setMontantDepense($montantDepense): void
    {
        $this->montantDepense = $montantDepense;
    }

    /**
     * Get the value of etat
     */ 
    public function getEtat(): int
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  void
     */ 
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    public function getDataPortefeuille()
    {
        $data['utilisateurs_id'] = $this->getUtilisateursId();
        $data['montant'] = $this->getMontant();
        $data['montantdepense'] = $this->getMontantDepense();
        $data['etat'] = $this->getEtat();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function getDataPortefeuilleUtilisateurs()
    {
        $data['nom'] = $this->getNom();
        $data['id'] = $this->getId();
        $data['utilisateurs_id'] = $this->getUtilisateursId();
        $data['montant'] = $this->getMontant();
        $data['montantdepense'] = $this->getMontantDepense();
        $data['etat'] = $this->getEtat();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionPortefeuille(): bool
    {
        $dataPortefeuille = $this->getDataPortefeuille();
        $retour = $this->insert($dataPortefeuille);
        return $retour;
    }

    public function updatePortefeuille(): bool
    {
        $dataPortefeuille = $this->getDataPortefeuille();
        $retour = $this->update($this->getId(), $dataPortefeuille);
        return $retour;
    }

    public function getSimplePortefeuille(): PorteFeuille
    {
        $instance = new PorteFeuille();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setUtilisateursId($row->utilisateurs_id);
        $instance->setMontant($row->montant);
        $instance->setMontantDepense($row->montantdepense);
        $instance->setEtat($row->etat);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function getAllPortefeuille()
    {
        $listePortefeuille = array();
        $query = $this->where("etat", $this->getEtat())->findAll();
        foreach($query as $row)
        {
            $instance = new PorteFeuille();
            $instance->setId($row->id);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listePortefeuille[] = $instance;
        }
        return $listePortefeuille;
    }

    public function getAllPortefeuilleByUtilisateursId()
    {
        $listePortefeuille = array();
        $query = $this->where("utilisateurs_id", $this->getUtilisateursId())
                    ->orderBy("created_at", "desc")
                    ->findAll();
        foreach($query as $row)
        {
            $instance = new PorteFeuille();
            $instance->setId($row->id);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listePortefeuille[] = $instance;
        }
        return $listePortefeuille;
    }

    public function getAllPortefeuilleUtilisateurs()
    {
        $listePortefeuille = array();
        $queryBuilder = $this->db->table("utilisateurs");
        $queryBuilder->join("portefeuilles", "utilisateurs.id = portefeuilles.utilisateurs_id");
        $queryBuilder->where("portefeuilles.etat", $this->getEtat());
        $queryBuilder->orderBy("portefeuilles.created_at", "desc");
        foreach($queryBuilder->get()->getResult() as $row)
        {
            $instance = new PorteFeuille();
            $instance->setId($row->id);
            $instance->setNom($row->nom);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listePortefeuille[] = $instance;
        }
        return $listePortefeuille;
    }

    public function getSimplePortefeuilleUtilisateurs()
    {
        $instance = new PorteFeuille();
        $queryBuilder = $this->db->table("utilisateurs");
        $queryBuilder->join("portefeuilles", "utilisateurs.id = portefeuilles.utilisateurs_id");
        $queryBuilder->where("portefeuilles.id", $this->getId());
        foreach($queryBuilder->get()->getResult() as $row)
        {
            $instance->setId($row->id);
            $instance->setNom($row->nom);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setMontant($row->montant);
            $instance->setMontantDepense($row->montantdepense);
            $instance->setEtat($row->etat);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
        }
        return $instance;
    }

    public function getValeurValidation()
    {
        $validation = "Non validé";
        if($this->getEtat() == 1)
        {
            $validation = "Validé";
        }
        return $validation;
    }

    public function getValeurDate()
    {
        $date = Fonction::getValeurDate($this->getCreatedAt());
        return $date;
    }

    public function getValeurHeure()
    {
        $heure = Fonction::getValeurHeure($this->getCreatedAt());
        return $heure;
    }

    public function getLastPortefeuillesId()
    {
        $lastId = 0;
        $sql = "select max(id) as id from portefeuilles where utilisateurs_id = %d";
        $sql = sprintf($sql, $this->getUtilisateursId());
        $row = $this->db->query($sql)->getRow();
        $lastId = $row->id;
        return $lastId;
    }
}
