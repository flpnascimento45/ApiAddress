<?php

namespace Source\Models;

use \Exception;
use \PDO;
use \Source\Db\Connection;

class StateReport extends State
{

    /**
     * qtde total de usuarios no estado
     * @var integer
     */
    private $countUsers;

    public function __construct($id = 0, $name = "", $initials = "", $countUsers = "")
    {

        parent::__construct($id, $name, $initials);
        $this->countUsers = $countUsers;

    }

    public function returnArray()
    {
        return get_object_vars($this);
    }

    /**
     * metodo retorna qtde de usuarios por estado
     */
    public function getUsersByState()
    {
        $conn = Connection::getInstance();

        $sql = "select s.id, s.name, s.initials, count(u.id) as qtd
                FROM state s inner join city c on (c.state_id = s.id)
                             inner join address a on (a.city_id = c.id)
                             inner join user u on (u.address_id = a.id) " .
            ($this->id > 0 ? " where s.id = :id " : "") .
            " GROUP BY s.id, s.name, s.initials";

        $rs = $conn->prepare($sql);

        if ($this->id > 0) {
            $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        }

        $rs->execute();

        $arrayState = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            if ($this->id > 0) {
                $this->name = $row->name;
                $this->initials = $row->initials;
                $this->countUsers = $row->qtd;
                return;
            }

            $newState = new StateReport($row->id, $row->name, $row->initials, $row->qtd);
            array_push($arrayState, $newState->returnArray());

        }

        // se chegar ate aqui, quer dizer que nao localizou o estado
        if ($this->id > 0) {
            throw new Exception('Estado não localizado!');
        }

        return $arrayState;
    }

}
