<?php

namespace App\Models\BaseModel;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $id;
    protected $createdAt;
    protected $updatedAt;


    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  void
     */ 
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  void
     */ 
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  void
     */ 
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}