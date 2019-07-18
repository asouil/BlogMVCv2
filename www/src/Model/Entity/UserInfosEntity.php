<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class UserInfosEntity extends Entity
{
    private $id;

    private $user_id;

    private $lastname;

    private $firstname;

    private $address;

    private $city;

    private $zip_code;

    private $country;

    private $phone;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Get the value of name
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Get the value of slug
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Get the value of content
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set the value of id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Set the value of id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * Set the value of name
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Set the value of slug
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Set the value of content
     */
    public function setAddress($address):void
    {
        $this->address = $address;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function setZipCode($zipCode): void
    {
        $this->zip_code = $zipCode;
    }

    public function setCountry($country): void
    {
        $this->country = $country;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }
}
