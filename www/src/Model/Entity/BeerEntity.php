<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class BeerEntity extends Entity
{
    /**
     * id de la biere
     * @var int
     */
    private $id;

    /**
     * titre de la bière
     * @var string
     */
    private $title;

    /**
     * url de l'image
     * @var  string
     */
    private $img;
    private $content;
    private $price_ht;
    private $stock;

    /**
     * recupère l'id de la bière
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * recupère le titre de la bière
     * @return string
     */

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPriceHt(): float
    {
        return $this->price_ht;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
