<?php

namespace Source\Models;

class City
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
     * @var State
     */
    private $state;

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

}
