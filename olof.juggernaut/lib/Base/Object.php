<?php

namespace Jugger\Base;

use Jugger\Exception\NotFoundPropertyException;

class Object
{
    public function __set($name, $value) {
        $methodName = "set" . $name;
        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        }
        else {
            $message  = "class: ". get_called_class();
            $message .= "; property: ". $name;
            throw new NotFoundPropertyException($message);
        }
    }
    
    public function __get($name) {
        $methodName = "get" . $name;
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        else {
            $message  = "class: ". get_called_class();
            $message .= "; property: ". $name;
            throw new NotFoundPropertyException($message);
        }
    }
    
    public function __isset($name) {
        $methodName = "get" . $name;
        if (method_exists($this, $methodName)) {
            return $this->$methodName() !== null;
        }
        else {
            return false;
        }
    }
    
    public function __unset($name) {
        $methodName = "set" . $name;
        if (method_exists($this, $methodName)) {
            $this->$methodName(null);
        }
    }
}