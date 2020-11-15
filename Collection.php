<?php
class Collection
{

    private $items = array();
    private $values = array();
    private $filtered = array();

    public function addItem($obj, $key)
    {
        if (isset($this->items[$key])) {
            throw new Exception("Key $key already in use.");
        } else {
            $this->items[$key] = $obj;
            array_push($this->values, $obj);
        }
    }

    public function filter($term, $fields, $inner){
        if(!isset($term)){
            return $this->values;
        }
        $this->filtered = [];
        foreach ($this->items as $key=>$obj){
            $properties = get_object_vars($obj);
            foreach ($fields as $field){
                if(is_array($properties[$field])){
                    foreach($properties[$field] as $outer){
                        if(stripos($outer->$inner, $term) !== false){
                            array_push($this->filtered, $obj);
                            
                        }
                    }
                } else {
                    if(stripos($properties[$field], $term) !== false){
                        array_push($this->filtered, $obj);
                    }
                }
            }
        }
        return array_unique($this->filtered, SORT_REGULAR);
    }

    public function deleteItem($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new Exception("Invalid key $key.");
        }
    }

    public function getItem($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            throw new Exception("Invalid key $key.");
        }
    }
    public function keys()
    {
        return array_keys($this->items);
    }
    public function length()
    {
        return count($this->items);
    }
    public function keyExists($key)
    {
        return isset($this->items[$key]);
    }
    public function all()
    {
        return $this->items;
    }

    public function allValues()
    {
        return $this->values;
    }
}
