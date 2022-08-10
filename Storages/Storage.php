<?php

require_once "../Models/User.php";

abstract class Storage
{
    abstract protected function __construct();
    abstract public static function getInstance();
    abstract public function getTableModel();
    abstract public function connection(string $model);
    abstract public function disconnection();
    abstract public function getAll();
    abstract public function getById(int $id);
    abstract public function deleteAll();
    abstract public function deleteById(int $id);
    abstract public function insert(object $model);
    abstract public function updateById(int $id, object $model);
    abstract public function where(string $col, string $cmp, $value);
    abstract public function orWhere(string $col, string $cmp, $value);
    abstract public function get();
}