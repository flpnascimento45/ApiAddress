<?php

namespace Source\Models;

use \Exception;
use \PDO;
use \Source\Db\Connection;

class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var Address
     */
    private $address;

    public function __construct($id = 0, $name = "", $login = "", $pass = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->pass = $pass;
    }

    public function returnArray()
    {
        $this->address = $this->address->returnArray();
        return get_object_vars($this);
    }

    /**
     * retona usuario pelo id
     * @return void
     */
    public function getUserById()
    {

        $conn = Connection::getInstance();

        $sql = "select u.id as user_id, u.name as user_name, u.login as user_login,
                       a.id as address_id, a.address, a.zip_code,
                       c.id as city_id, c.name as city_name,
                       s.id as state_id, s.name as state_name, s.initials
                from user u left join address a on (u.address_id = a.id)
                            left join city c on (a.city_id = c.id)
                            left join state s on (c.state_id = s.id)
                where u.id = :id";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':id', $this->id, PDO::PARAM_INT);
        $rs->execute();

        while ($row = $rs->fetch(PDO::FETCH_OBJ)) {

            $this->name = $row->user_name;
            $this->login = $row->user_login;

            $this->address = new Address($row->address_id, $row->address, $row->zip_code);
            $this->address->setCity(new City($row->city_id, $row->city_name));
            $this->address->getCity()->setState(new State($row->state_id, $row->state_name, $row->initials));

            return;

        }

        throw new Exception('Usuário não localizado!');

    }

    /**
     * @param User $user
     * @return void
     */
    public function insert($user)
    {

        $conn = Connection::getInstance();

        $sqlAddress = "select count(id) as qtd from address where id = :id";

        $rs = $conn->prepare($sqlAddress);
        $rs->bindValue(':id', $this->address->getId(), PDO::PARAM_INT);
        $rs->execute();

        if (!$rs->fetchColumn() > 0) {
            throw new Exception('Endereço não localizado!');
        }

        $sql = "insert into user (name, login, pass, address_id)
                values (:name, :login, md5(:pass), :address_id);";

        $rs = $conn->prepare($sql);
        $rs->bindValue(':name', $this->name, PDO::PARAM_STR);
        $rs->bindValue(':login', $this->login, PDO::PARAM_STR);
        $rs->bindValue(':pass', $this->pass, PDO::PARAM_STR);
        $rs->bindValue(':address_id', $this->address->getId(), PDO::PARAM_INT);

        if ($rs->execute()) {
            $user->id = $conn->lastInsertId();
        } else {
            throw new Exception('Falha ao inserir usuário');
        }

    }

}
