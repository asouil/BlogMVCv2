<?php
namespace App\Model\Entity;

use Core\Model\Entity;

class OrderEntity extends Entity
{
    private $id;
    private $user_infos_id;
    private $price_ht;
    private $port;
    private $tva;
    private $status_id;
    private $token;
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getUserInfos()
    {
        return $this->user_infos_id;
    }

    public function getPriceHt()
    {
        return $this->price_ht;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getTva()
    {
        return $this->tva;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getStatus()
    {
        return $this->status_id;
    }

    public function getToken()
    {
        return $this->token;
    }
}
