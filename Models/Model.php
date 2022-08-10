<?php

require_once "../Storages/StorageDatabase.php";
require_once "../Factories/CreatorStorage.php";

class Model
{
    private $connect;

    protected $table;
    protected static $type;

    protected function __construct()
    {
        if (!static::$type) {
            static::$type = getenv('STORAGE_TYPE');
        }

        $this->connect = (new CreatorStorage())->getStorage(static::$type)->connection($this->table);
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Property not found !", 404);
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new \Exception("Property not found !", 404);
        }
    }

    public static function connection() : Model
    {
        static $instances = array();
        print_r($instances);
        $calledClass = get_called_class();
        if (!isset($instances[$calledClass])) {
            $instances[$calledClass] = new $calledClass();
        }
        // print_r($instances[$calledClass]);
        return $instances[$calledClass];
    }

    public function all()
    {
        return $this->connect->getAll()->get();
    }

    public function get()
    {
        return $this->connect->get();
    }

    public function where(string $col, string $cmp, $value) : Model
    {
        $this->connect->where($col, $cmp, $value);
        return $this;
    }

    public function orWhere(string $col, string $cmp, $value) : Model
    {
        $this->connect->orWhere($col, $cmp, $value);
        return $this;
    }
}