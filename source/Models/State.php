<?php

namespace Source\Models;

use \Exception;
use \PDO;
use \Source\Db\Connection;

class State
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
     * @var string
     */
    protected $initials;

    public function __construct($id, $name = "", $initials = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->initials = $initials;
    }

    public function returnArray()
    {
        return get_object_vars($this);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * metodo para buscar estado pelo id
     * @return void
     */
    public function getStateById()
    {

        $conn = Connection::getInstance();

        $sql = "select name, initials
                from state
                where id = :id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        $rs->execute();

        $arrayAddress = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $this->name = $row->name;
            $this->initials = $row->initials;

            return;

        }

        throw new Exception('Estado não localizado!');

    }

    /**
     * metodo para listar todos estados
     * @return array
     */
    public static function getAllState()
    {

        $conn = Connection::getInstance();

        $sql = "select id, name, initials
                from state";

        $rs = $conn->prepare($sql);
        $rs->execute();

        $arrayState = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $newState = new State($row->id, $row->name, $row->initials);
            array_push($arrayState, $newState->returnArray());

        }

        return $arrayState;

    }

}
