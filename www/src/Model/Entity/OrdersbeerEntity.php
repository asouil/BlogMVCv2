<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class OrdersBeerEntity extends Entity
{
    private $id;
    private $user_id;
    private $beer_id;
    private $beerpriceHT;
    private $beerQty;
    private $token;

    public function getId() {
        return $this->id;
    }

    public function getBeerId() {
        return $this->beer_id;
    }

    public function getBeerQty() {
        return $this->beerQty;
    }

    public function getBeerprice() {
        return $this->beerpriceHT;
    }

    public function getPrice() {
        return $this->priceHT;
    }

    public function getToken() 
    {
        return $this->token;
    }

}
