<?php
class Collection
{

    private $items = array();
    private $values = array();

    public function addItem($obj, $key)
    {
        if (isset($this->items[$key])) {
            throw new Exception("Key $key already in use.");
        } else {
            $this->items[$key] = $obj;
            array_push($this->values, $obj);
        }
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
