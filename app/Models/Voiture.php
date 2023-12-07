<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Voiture extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'voitures';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['utilisateurs_id', 'model', 'marque', 'matricule', 'types', 'etat', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'model' => ['required', 'min_length[3]'],
        'marque' => ['required', 'min_length[3]'],
        'matricule' => [],
        'types' => ['required']
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
    protected $model;
    protected $marque;
    protected $matricule;
    protected $types;
    protected $etat;
    protected $couleur;
    

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
     * Get the value of model
     */ 
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  void
     */ 
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * Get the value of marque
     */ 
    public function getMarque(): string
    {
        return $this->marque;
    }

    /**
     * Set the value of marque
     *
     * @return  void
     */ 
    public function setMarque($marque): void
    {
        $this->marque = $marque;
    }

    /**
     * Get the value of matricule
     */ 
    public function getMatricule(): string
    {
        return $this->matricule;
    }

    /**
     * Set the value of matricule
     *
     * @return  void
     */ 
    public function setMatricule($matricule): void
    {
        $this->matricule = $matricule;
    }

    /**
     * Get the value of types
     */ 
    public function getTypes(): string
    {
        return $this->types;
    }

    /**
     * Set the value of types
     *
     * @return  void
     */ 
    public function setTypes($types): void
    {
        $this->types = $types;
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

    /**
     * Get the value of couleur
     */ 
    public function getCouleur(): string
    {
        return $this->couleur;
    }

    /**
     * Set the value of couleur
     *
     * @return  void
     */ 
    public function setCouleur($couleur): void
    {
        $this->couleur = $couleur;
    }

    public function getListeCouleursVoiture($taille): array
    {
        $listeCouleursVoitures = array();
        $listeCouleurs = array("bg-success", "bg-danger", "bg-cyan", "bg-warning", "bg-info", "bg-primary", "bg-secondary");
        $listeCouleursVoitures = Fonction::getListeCouleurs($listeCouleurs, $taille);
        return $listeCouleursVoitures;
    }

    public function getStatus(): string
    {
        $status = "Libre";
        if($this->getEtat() == 1)
        {
            $status = "Occupée";
        }
        return $status;
    }

    public function getDataVoiture()
    {
        $data['utilisateurs_id'] = $this->getUtilisateursId();
        $data['model'] = $this->getModel();
        $data['marque'] = $this->getMarque();
        $data['matricule'] = $this->getMatricule();
        $data['types'] = $this->getTypes();
        $data['etat'] = $this->getEtat();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function getDataVoitureById()
    {
        $data['id'] = $this->getId();
        $data['utilisateurs_id'] = $this->getUtilisateursId();
        $data['model'] = $this->getModel();
        $data['marque'] = $this->getMarque();
        $data['matricule'] = $this->getMatricule();
        $data['types'] = $this->getTypes();
        $data['etat'] = $this->getEtat();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionVoitures()
    {
        $validation = \Config\Services::validation();
        $this->validationRules['matricule'] = ['required', 'is_unique[voitures.matricule]'];
        $validation->setRules($this->validationRules);
        $dataVoiture = $this->getDataVoiture();
        if(!$validation->run($dataVoiture))
        {
            return $validation->getErrors();
        }
        else
        {
            return $this->insert($dataVoiture);
        }
    }

    public function updateVoiture(): bool
    {
        $dataVoiture = $this->getDataVoiture();
        $retour = $this->update($this->getId(), $dataVoiture);
        return $retour;
    }

    public function suppressionVoiture()
    {
        $this->delete($this->getId());
    }

    public function getSimpleVoiture(): Voiture
    {
        $instance = new Voiture();
        $row = $this->find($this->getId());
        $instance = new Voiture();
        $instance->setId($row->id);
        $instance->setUtilisateursId($row->utilisateurs_id);
        $instance->setModel($row->model);
        $instance->setMarque($row->marque);
        $instance->setMatricule($row->matricule);
        $instance->setTypes($row->types);
        $instance->setEtat($row->etat);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function getAllVoitureByUtilisateur()
    {
        $indice = 0;
        $listeVoiture = array();
        $query = $this->where("utilisateurs_id", $this->getUtilisateursId())->findAll();
        $listeCouleursVoitures = $this->getListeCouleursVoiture(count($query));
        foreach($query as $row)
        {
            $instance = new Voiture();
            $instance->setId($row->id);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setModel($row->model);
            $instance->setMarque($row->marque);
            $instance->setMatricule($row->matricule);
            $instance->setTypes($row->types);
            $instance->setEtat($row->etat);
            $instance->setCouleur($listeCouleursVoitures[$indice++]);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeVoiture[] = $instance;
        }
        return $listeVoiture;
    }

    public function getAllVoitureNonOccupeByUtilisateur()
    {
        $listeVoiture = array();
        $sql = "select * from voitures where utilisateurs_id = %d and etat = %d";
        $sql= sprintf($sql, $this->getUtilisateursId(), $this->getEtat());
        $query = $this->db->query($sql);
        foreach($query->getResult() as $row)
        {
            $instance = new Voiture();
            $instance->setId($row->id);
            $instance->setUtilisateursId($row->utilisateurs_id);
            $instance->setModel($row->model);
            $instance->setMarque($row->marque);
            $instance->setMatricule($row->matricule);
            $instance->setTypes($row->types);
            $instance->setEtat($row->etat);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeVoiture[] = $instance;
        }
        return $listeVoiture;
    }

    public function verificationProprietaireVoiture(): bool
    {
        $verification = false;
        $sql = "select count(id) as id from voitures where id = %d and utilisateurs_id = %d";
        $sql = sprintf($sql, $this->getId(), $this->getUtilisateursId());
        $query = $this->db->query($sql);
        if($query->getRow()->id == 1)
        {
            $verification = true;
        }
        return $verification;
    }

    public function verificationEffractionVoiture(): bool
    {
        $verification = false;
        $instanceParametre = new Parametre();
        $instanceParametre->setId(1);
        $parametre = $instanceParametre->getSimpleParametre();
        $sql = "select etatparametre, etatencours from viewsetatparking where voitures_id = %d";
        $sql = sprintf($sql, $this->getId());
        $row = $this->db->query($sql);
        if($parametre->getOptions() == "Normale")
        {
            if($row->getRow()->etatencours == "En infraction")
            {
                $verification = true;
            }
        }
        else
        {
            if($row->getRow()->etatparametre == "En infraction")
            {
                $verification = true;
            }
        }
        return $verification;
    }

    public function getTotalVoitureByUtilisateurs(): int
    {
        $totalVoiture = 0;
        $sql = "select count(id) as total_voitures from voitures where utilisateurs_id = %d";
        $sql = sprintf($sql, $this->getUtilisateursId());
        $row = $this->db->query($sql);
        $totalVoiture = $row->getRow()->total_voitures;
        return $totalVoiture;
    }
}
