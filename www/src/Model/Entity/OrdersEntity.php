<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class OrdersEntity extends Entity
{
    private $id;

    private $userinfos_id;

    private $priceTTC;

    private $token;

    private $created_at;

    private $status_id;

    private $ordersTVA;

    private $port;
        /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
            /**
     * Get the value of id
     */
    public function getUserinfosId()
    {
        return $this->userinfos_id;
    }
    public function getPrice() {
        return $this->priceTTC;
    }
        /**
     * Get the value of created_at
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return new \DateTime($this->createdAt);
    }

    public function getStatus() {
        return $this->status_id;
    }
    public function getOrdersTVA() {
        return $this->ordersTVA;
    }
    public function getPort() {
        return $this->port;
    }
}