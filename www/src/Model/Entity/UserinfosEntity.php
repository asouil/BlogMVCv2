<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class UserinfosEntity extends Entity
{
    public $id;
    public $user_id;
    public $lastname;
    public $firstname;
    public $address;
    public $city;
    public $zipCode;
    public $country;
    public $phone;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the value of name
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of slug
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the value of content
     */
    public function getAddress()
    {
        return $this->address;
    }
    public function getCity() {
        return $this->city;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getPhone() {
        return $this->phone;
    }
    public function getUrl(): string
    {
        return \App\App::getInstance()
            ->getRouter()
            ->url('user_address', [
                "user_id" => $this->getUserId(),
                "id" => $this->getId()
            ]);
    }
}