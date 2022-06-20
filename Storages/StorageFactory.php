<?php

require_once "../Models/User.php";

abstract class StorageFactory
{
    abstract public static function connection(array $storage);
    abstract public static function disconnection();
    abstract public static function getAll();
    abstract public static function getById(int $id);
    abstract public static function deleteAll();
    abstract public static function deleteById(int $id);
    abstract public static function insert(User $user);
    abstract public static function updateById(int $id, User $user);
}