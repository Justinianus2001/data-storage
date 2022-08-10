<?php

class ModelTest
{
    private $a;
    private $b;
    private $c;
    private $d;
    private $e;

    public function __construct($a, $b, $c, $d, $e) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->e = $e;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

$var = new ModelTest(1, 2, 3, 4, 5);
print_r($var->a);
print_r($var->b);
$var->b = -2;
print_r($var->b);