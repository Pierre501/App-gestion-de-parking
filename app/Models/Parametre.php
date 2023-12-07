<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Parametre extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'parametres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['dateparametre', 'heureparametre', 'options', 'created_at', 'updated_at'];

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

    protected $dateParametre;
    protected $heureParametre;
    protected $options;

    /**
     * Get the value of dateParametre
     */ 
    public function getDateParametre(): string
    {
        return $this->dateParametre;
    }

    /**
     * Set the value of dateParametre
     *
     * @return  void
     */ 
    public function setDateParametre($dateParametre): void
    {
        $this->dateParametre = $dateParametre;
    }

    /**
     * Get the value of heureParametre
     */ 
    public function getHeureParametre(): string
    {
        return $this->heureParametre;
    }

    /**
     * Set the value of heureParametre
     *
     * @return  void
     */ 
    public function setHeureParametre($heureParametre): void
    {
        $this->heureParametre = $heureParametre;
    }

    /**
     * Get the value of options
     */ 
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @return  void
     */ 
    public function setOptions($options): void
    {
        $this->options = $options;
    }

    public function getDataParametre(): array
    {
        $data['dateparametre'] = $this->getDateParametre();
        $data['heureparametre'] = $this->getHeureParametre();
        $data['options'] = $this->getOptions();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function updateParametre()
    {
        $listeDataParametre = $this->getDataParametre();
        $this->update($this->getId(), $listeDataParametre);
    }

    public function getSimpleParametre(): Parametre
    {
        $instance = new Parametre();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setDateParametre($row->dateparametre);
        $instance->setHeureParametre($row->heureparametre);
        $instance->setOptions($row->options);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }
}
