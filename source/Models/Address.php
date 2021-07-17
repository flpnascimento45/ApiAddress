<?php

namespace Source\Models;

use \Exception;
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
     * metodo para listar endereços pela cidade
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

    /**
     * metodo para buscar endereço pelo id
     * @return void
     */
    public function getAddressById()
    {

        $conn = Connection::getInstance();

        $sql = "select a.address, a.zip_code,
                       c.id as city_id, c.name as city_name,
                       s.id as state_id, s.name as state_name, s.initials
                from address a left join city c on (c.id = a.city_id)
                               left join state s on (s.id = c.state_id)
                where a.id = :id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        $rs->execute();

        $arrayAddress = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $this->address = $row->address;
            $this->zip_code = $row->zip_code;

            $this->setCity(new City($row->city_id, $row->city_name));
            $this->getCity()->setState(new State($row->state_id, $row->state_name, $row->initials));

            return;

        }

        throw new Exception('Endereço não localizado!');

    }

}
