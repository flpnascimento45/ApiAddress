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
    public function __construct($id, $name, $state = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->state = $state;
    }

    /**
     * @param State $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function returnArray()
    {
        $this->state = $this->state->returnArray();
        return get_object_vars($this);
    }

}
