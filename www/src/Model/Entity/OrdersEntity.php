<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class OrdersEntity extends Entity
{
    private $id;

    private $user_id;
    private $userinfos_id;

    private $priceTTC;

    private $priceHT;

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
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getPriceTTC() {
        $this->priceTTC=$this->priceHT*$this->ordersTVA;
        return $this->priceTTC;
    }
    public function getPriceHT(){
        return $this->priceHT;
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
    public function getToken() {
        return $this->token;
    }
}