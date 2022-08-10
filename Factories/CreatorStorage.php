<?php

require_once "../Storages/StorageDatabase.php";
require_once "../Storages/StorageJson.php";
require_once "Creator.php";

class CreatorStorage implements Creator
{
    public function getStorage(string $type) : object
    {
        switch ($type)
        {
            case 'database':
                return StorageDatabase::getInstance();
            case 'json':
                return StorageJson::getInstance();
            default:
                throw new \Exception("Invalid Storage", 500);
        }
    }
}