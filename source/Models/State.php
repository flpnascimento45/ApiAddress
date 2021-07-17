<?php

namespace Source\Models;

class State
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
    private $initials;

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

}
