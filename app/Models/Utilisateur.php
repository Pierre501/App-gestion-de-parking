<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Utilisateur extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'utilisateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nom', 'username', 'motdepasse', 'etat', 'roles', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nom' => ['required', 'min_length[3]', 'max_length[150]'],
        'username' => [],
        'motdepasse' => ['required', 'min_length[8]'],
        'motdepasseconfirme' => [],
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

    protected $nom;
    protected $username;
    protected $motdepasse;
    protected $etat;
    protected $roles;

    /**
     * Get the value of nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  void
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  void
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * Get the value of motdepasse
     */
    public function getMotdepasse(): string
    {
        return $this->motdepasse;
    }

    /**
     * Set the value of motdepasse
     *
     * @return  void
     */
    public function setMotdepasse($motdepasse): void
    {
        $this->motdepasse = $motdepasse;
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
     * Get the value of roles
     */
    public function getRoles(): int
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  void
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    public function getSimpleNom(): string
    {
        $listeNom = explode(" ", $this->getNom());
        $nom = $listeNom[0];
        return $nom;
    }

    public function getSimplePrenom(): string
    {
        $listeNom = explode(" ", $this->getNom());
        $prenom = Fonction::concatenation($listeNom);
        return $prenom;
    }

    public function login(): bool
    {
        $login = false;
        $sql = "select count(*) as row, motdepasse from utilisateurs where username = %s and etat = %s";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()), $this->db->escape($this->getEtat()));
        $query = $this->db->query($sql);
        $row = $query->getRow();
        if ($row->row == 1 && password_verify($this->getMotdepasse(), $row->motdepasse)) 
        {
            $login = true;
        }
        return $login;
    }

    public function getDataUtilisateurs()
    {
        $data['nom'] = $this->getNom();
        $data['username'] = $this->getUsername();
        $data['motdepasse'] = $this->getMotdepasse();
        $data['etat'] = $this->getEtat();
        $data['roles'] = $this->getRoles();
        $data['created_at'] = $this->getCreatedAt();
        $data['updated_at'] = $this->getUpdatedAt();
        return $data;
    }

    public function insertionUtilisateur($motdepasseconfirme)
    {
        $validation = \Config\Services::validation();
        $this->validationRules['username'] = ['required', 'valid_email', 'is_unique[utilisateurs.username]'];
        $this->validationRules['motdepasseconfirme'] = ['required', 'matches[motdepasse]'];
        $validation->setRules($this->validationRules);
        $dataUtilisateur1 = $this->getDataUtilisateurs();
        $data['motdepasseconfirme'] = $motdepasseconfirme;
        $dataUtilisateur = array_merge($dataUtilisateur1, $data);
        if(!$validation->run($dataUtilisateur))
        {
            return $validation->getErrors();
        }
        else
        {
            unset($dataUtilisateur['motdepasseconfirme']);
            $dataUtilisateur['motdepasse'] = password_hash($dataUtilisateur['motdepasse'], PASSWORD_DEFAULT);
            return $this->insert($dataUtilisateur);
        }
    }

    public function updateUtilisateur()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->validationRules);
        $dataUtilisateur = $this->getDataUtilisateurs();
        if(!$validation->run($dataUtilisateur))
        {
            return $validation->getErrors();
        }
        else
        {
            return $this->update($this->getId(), $dataUtilisateur);
        }
    }

    public function updateMotDePasse($motdepasseconfirme)
    {
        $validation = \Config\Services::validation();
        $this->validationRules['nom'] = [];
        $this->validationRules['motdepasseconfirme'] = ['required', 'matches[motdepasse]'];
        $validation->setRules($this->validationRules);
        $dataUtilisateur1 = $this->getDataUtilisateurs();
        $data['motdepasseconfirme'] = $motdepasseconfirme;
        $dataUtilisateur = array_merge($dataUtilisateur1, $data);
        if(!$validation->run($dataUtilisateur))
        {
            return $validation->getErrors();
        }
        else
        {
            unset($dataUtilisateur['motdepasseconfirme']);
            $dataUtilisateur['motdepasse'] = password_hash($dataUtilisateur['motdepasse'], PASSWORD_DEFAULT);
            return $this->update($this->getId(), $dataUtilisateur);
        }
    }

    public function getSimpleUtilisateur()
    {
        $sql = "select * from utilisateurs where username = %s";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()));
        $query = $this->db->query($sql);
        $row = $query->getRow();
        $utilisateur = new Utilisateur();
        $utilisateur->setId($row->id);
        $utilisateur->setNom($row->nom);
        $utilisateur->setUsername($row->username);
        $utilisateur->setMotdepasse($row->motdepasse);
        $utilisateur->setEtat($row->etat);
        $utilisateur->setRoles($row->roles);
        $utilisateur->setCreatedAt($row->created_at);
        $utilisateur->setUpdatedAt($row->updated_at);
        return $utilisateur;
    }

    public function getSimpleUtilisateurById(): Utilisateur
    {
        $instance = new Utilisateur();
        $row = $this->find($this->getId());
        $instance->setId($row->id);
        $instance->setNom($row->nom);
        $instance->setUsername($row->username);
        $instance->setMotdepasse($row->motdepasse);
        $instance->setEtat($row->etat);
        $instance->setRoles($row->roles);
        $instance->setCreatedAt($row->created_at);
        $instance->setUpdatedAt($row->updated_at);
        return $instance;
    }

    public function isAdministrateur()
    {
        $verification = false;
        $sql = "select * from utilisateurs where id = %d";
        $sql = sprintf($sql, $this->getId());
        $this->db = db_connect();
        $query = $this->db->query($sql);
        $row = $query->getRowArray();
        if ($row['roles'] == 1) 
        {
            $verification = true;
        }
        $this->db->close();
        return $verification;
    }

    public function getSolde(): int|float
    {
        $solde = 0;
        $sql = "select * from viewsutilisateur where id = %d and etat = 1";
        $sql = sprintf($sql, $this->getId());
        $query = $this->db->query($sql);
        $row = $query->getRowArray();
        $solde = $row['solde'];
        return $solde;
    }

    public function getNombreTotalUtilisateurs(): int
    {
        $totalUtilisateurs = 0;
        $sql = "select count(id) as totalUtilisateurs from utilisateurs";
        $row = $this->db->query($sql);
        $totalUtilisateurs = $row->getRow()->totalUtilisateurs;
        return $totalUtilisateurs;
    }

    public function getNombreTotalNouveauUtilisateurs(): int
    {
        $totalNouveauUtilisateurs = 0;
        $instanceDate = new Date();
        $listeDate = $instanceDate->getDateDebutEtFinDuMois(date("m"), date("Y"));
        $sql = "select count(*) as totalNouveauUtilisateurs from utilisateurs where date(created_at) between %s and %s";
        $sql = sprintf($sql, $this->db->escape($listeDate[0]), $this->db->escape($listeDate[1]));
        $row = $this->db->query($sql);
        $totalNouveauUtilisateurs = $row->getRow()->totalNouveauUtilisateurs;
        return $totalNouveauUtilisateurs;
    }

    public function getAllUtilisateurs(): array
    {
        $listeUtilisateurs = array();
        $query = $this->where("roles", $this->getRoles())->findAll();
        foreach($query as $row)
        {
            $instance = new Utilisateur();
            $instance->setId($row->id);
            $instance->setNom($row->nom);
            $instance->setUsername($row->username);
            $instance->setMotdepasse($row->motdepasse);
            $instance->setEtat($row->etat);
            $instance->setRoles($row->roles);
            $instance->setCreatedAt($row->created_at);
            $instance->setUpdatedAt($row->updated_at);
            $listeUtilisateurs[] = $instance;
        }
        return $listeUtilisateurs;
    }

    public function getDateCreation()
    {
        return Fonction::getValeurDate($this->getCreatedAt());
    }
}
