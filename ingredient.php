<?php

class Ingredient
{
    //Properties
    public $name;
    public $qty;
    public $measurement;

    //Getter/Setter
    function set_name($name)
    {
        $this->name = $name;
    }
    function get_name()
    {
        return $this->name;
    }
    function set_qty($qty)
    {
        $this->qty = $qty;
    }
    function get_qty()
    {
        if (ceil($this->qty) - floor($this->qty) == 0) {
            return number_format($this->qty, 0);
        }
        return number_format($this->qty, 2);
    }
    function set_measurement($measurement)
    {
        $this->measurement = $measurement;
    }
    function get_measurement()
    {
        return $this->measurement;
    }

}
