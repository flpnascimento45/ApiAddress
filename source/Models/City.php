<?php

namespace Source\Models;

use \Exception;
use \PDO;
use \Source\Db\Connection;

class City
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var State
     */
    protected $state;

    /**
     * @param integer $id
     * @param string $name
     * @param State $state
     */
    public function __construct($id, $name = "")
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param State $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function returnArray()
    {
        $this->state = is_null($this->state) ? null : $this->state->returnArray();
        return get_object_vars($this);
    }

    /**
     * metodo para listar cidade pelo estado
     * @return array
     */
    public function getCityByState()
    {

        $conn = Connection::getInstance();

        $sql = "select id, name
                from city
                where state_id = :state_id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':state_id', $this->state->getId(), PDO::PARAM_INT);
        $rs->execute();

        $arrayCity = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
            $newCity = new City($row->id, $row->name);
            array_push($arrayCity, $newCity->returnArray());
        }

        return $arrayCity;

    }

    /**
     * metodo para buscar cidade pelo id
     * @return void
     */
    public function getCityById()
    {

        $conn = Connection::getInstance();

        $sql = "select c.name as city_name,
                       s.id as state_id, s.name as state_name, s.initials
                from city c inner join state s on (s.id = c.state_id)
                where c.id = :id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        $rs->execute();

        $arrayAddress = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $this->name = $row->city_name;
            $this->setState(new State($row->state_id, $row->state_name, $row->initials));

            return;

        }

        throw new Exception('Cidade não localizada!');

    }

    /**
     * metodo para listar todas cidades
     * @return array
     */
    public static function getAllCity()
    {

        $conn = Connection::getInstance();

        $sql = "select c.id as city_id, c.name as city_name,
                       s.id as state_id, s.name as state_name, s.initials
                from city c inner join state s on (s.id = c.state_id)";

        $rs = $conn->prepare($sql);
        $rs->execute();

        $arrayCity = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $newCity = new City($row->city_id, $row->city_name);
            $newCity->setState(new State($row->state_id, $row->state_name, $row->initials));

            array_push($arrayCity, $newCity->returnArray());

        }

        return $arrayCity;

    }

}
