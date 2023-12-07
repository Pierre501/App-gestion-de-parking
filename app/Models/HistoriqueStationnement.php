<?php

namespace App\Models;


class HistoriqueStationnement extends Stationnement
{
    protected $DBGroup          = 'default';
    protected $table            = 'historique_stationnements';
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

    public function insertionHistoriqueStationnements(): bool
    {
        $retour = $this->insertionStationnements();
        return $retour;
    }

    public function getSimpleHistoriqueStationnementByVoituresId(): HistoriqueStationnement
    {
        $sql = "select * from historique_stationnements where id in (select max(id) from historique_stationnements where voitures_id = %d)";
        $sql = sprintf($sql, $this->getVoituresId());
        $row = $this->db->query($sql)->getRow();
        $instance = new HistoriqueStationnement();
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
