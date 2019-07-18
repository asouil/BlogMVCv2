<?php
namespace App\Model\Entity;

use Core\Model\Entity;

class OrderLineEntity extends Entity
{
    private $id;
    private $user_id;
    private $beer_id;
    private $beer_price_ht;
    private $beer_qty;
    private $token;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getBeerId()
    {
        return $this->beer_id;
    }

    public function getPriceHt()
    {
        return $this->beer_price_ht;
    }

    public function getBeerQty()
    {
        return $this->beer_qty;
    }

    public function getToken()
    {
        return $this->token;
    }
}
