<?php

class Ingredient {
    //Properties
    public $id;
    public $name;
    public $qty;
    public $measurement;

    //Getter/Setter
    function set_qty($qty) {
        $this->qty = $qty;
    }

    //Methods

    public function combine($other){
        if($this->measurement == $other->measurement){
            $new = new Ingredient();
            $new->id = $this->id;
            $new->qty = $this->qty + $other->qty;
            $new->measurement = $this->measurement;
        } else {
            $new = $this->convert($other);
        }
        return $new;
    }

    function convert($other){
        //TODO figure out measurement conversions
    }


}
