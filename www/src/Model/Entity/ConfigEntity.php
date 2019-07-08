<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class ConfigEntity extends Entity
{
    private $id;
    private $date;
    private $tva;
    private $port;
    private $ship_limit;

    private function getId(){
        return $this->id;
    }
    private function getDate(){
        return $this->date;
    }
    private function getTva(){
        return $this->tva;
    }
    private function getPort(){
        return $this->port;;
    }
    private function getShipLimit(){
        return $this->ship_limit;
    }
}