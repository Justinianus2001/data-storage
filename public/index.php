<?php

require_once "../Storages/StorageDatabase.php";
require_once "../Storages/StorageJson.php";
require_once "../Models/User.php";

$storageDatabase = [
    'server_name' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test',
];

$storageJson = [
    'file' => 'users.json',
];

$user = new User('Nguyen Van A', '0935229074', 'nguyenvana@gmail.com', 'password');

StorageDatabase::connection($storageDatabase);

// $val = StorageDatabase::getAll();

// print_r(StorageDatabase::getAll());
// print_r(StorageDatabase::getById(18));
// print_r(StorageDatabase::deleteAll());
// print_r(StorageDatabase::deleteById(20));
// print_r(StorageDatabase::insert($user));
// print_r(StorageDatabase::updateById(1783, $user));

StorageDatabase::disconnection();

// $lst = [];
// for ($i = 0; $i < count($val); $i ++) {
//     $res = [];
//     $res['name'] = $val[$i]->getName();
//     $res['phone'] = $val[$i]->getPhone();
//     $res['email'] = $val[$i]->getEmail();
//     $res['password'] = $val[$i]->getPassword();
//     $lst[$i + 1] = $res;
// }

// file_put_contents(__DIR__ . '/users.json', json_encode($lst, JSON_PRETTY_PRINT));

// StorageDatabase::connection($storageDatabase);

// print_r(StorageDatabase::getAll());
// print_r(StorageDatabase::getById(18));
// print_r(StorageDatabase::deleteAll());
// print_r(StorageDatabase::deleteById(20));
// print_r(StorageDatabase::insert($user));
// print_r(StorageDatabase::updateById(1783, $user));

// StorageDatabase::disconnection();

StorageJson::connection($storageJson);

// print_r(StorageJson::getAll());
// print_r(StorageJson::getById(10));
// print_r(StorageJson::deleteAll());
// print_r(StorageJson::deleteById(2));
// print_r(StorageJson::insert($user));
print_r(StorageJson::updateById(6, $user));

StorageJson::disconnection();