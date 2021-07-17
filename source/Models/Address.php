<?php

namespace Source\Models;

use \PDO;
use \Source\Db\Connection;

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

    /**
     * metodo para listar endereços
     * @return array
     */
    public function getAddressByCity()
    {

        $conn = Connection::getInstance();

        $sql = "select id, address, zip_code
                from address
                where city_id = :city_id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':city_id', $this->city->getId(), PDO::PARAM_INT);
        $rs->execute();

        $arrayAddress = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $newAddress = new Address($row->id, $row->address, $row->zip_code);
            array_push($arrayAddress, $newAddress->returnArray());
        }

        return $arrayAddress;

    }

}
