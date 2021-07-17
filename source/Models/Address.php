<?php

namespace Source\Models;

class Address
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var City
     */
    private $city;

    public function __construct($id, $address = "", $zipCode = "")
    {
        $this->id = $id == 0 ? null : $id;
        $this->address = $address;
        $this->zipCode = $zipCode;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function returnArray()
    {
        $this->city = is_null($this->city) ? null : $this->city->returnArray();
        return get_object_vars($this);
    }

}
