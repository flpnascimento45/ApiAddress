<?php

namespace Source\Models;

use \Exception;
use \PDO;
use \Source\Db\Connection;

class CityReport extends City
{

    /**
     * qtde total de usuarios na cidade
     * @var integer
     */
    private $countUsers;

    public function __construct($id = 0, $name = "", $countUsers = "")
    {

        parent::__construct($id, $name);
        $this->countUsers = $countUsers;

    }

    public function returnArray()
    {
        $this->state = is_null($this->state) ? null : $this->state->returnArray();
        return get_object_vars($this);
    }

    /**
     * metodo retorna qtde de usuarios por cidade
     */
    public function getUsersByCity()
    {
        $conn = Connection::getInstance();

        $sql = "select s.id as state_id, s.name as state_name, s.initials,
                       c.id as city_id, c.name as city_name,
                       count(u.id) as qtd
                FROM state s inner join city c on (c.state_id = s.id)
                             inner join address a on (a.city_id = c.id)
                             inner join user u on (u.address_id = a.id) " .
            ($this->id > 0 ? " where c.id = :id " : "") .
            " GROUP BY s.id, s.name, s.initials, c.id, c.name " .
            " ORDER BY s.id, c.id ";

        $rs = $conn->prepare($sql);

        if ($this->id > 0) {
            $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        }

        $rs->execute();

        $arrayCity = array();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            if ($this->id > 0) {

                $this->name = $row->city_name;
                $this->countUsers = $row->qtd;
                $this->setState(new State($row->state_id, $row->state_name, $row->initials));

                return;
            }

            $newCity = new CityReport($row->city_id, $row->city_name, $row->qtd);
            $newCity->setState(new State($row->state_id, $row->state_name, $row->initials));

            array_push($arrayCity, $newCity->returnArray());

        }

        // se chegar ate aqui, quer dizer que nao localizou a cidade
        if ($this->id > 0) {
            throw new Exception('Cidade não localizada!');
        }

        return $arrayCity;
    }

}
