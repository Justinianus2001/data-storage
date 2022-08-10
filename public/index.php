<?php

require_once "LoadEnv.php";
require_once "../Factories/CreatorStorage.php";
require_once "../Models/User.php";
require_once "../Models/Product.php";

$user = User::create([
    'id' => null,
    'name' => 'Nguyen Van A',
    'phone' => '0935229074',
    'email' => 'nguyenvana@gmail.com',
    'password' => 'password']);

// $storageDB = (new CreatorStorage())->getStorage('database');
// print_r($storageDB->connection('users')->getAll()->where('email', '=', 3)->orWhere('phone', '=', 2)->get());
// print_r($storageDB->connection('users')->getById(1793)->get());
// print_r($storageDB->connection('users')->deleteAll()->get());
// print_r($storageDB->connection('users')->deleteById(1788)->get());
// print_r($storageDB->connection('users')->insert($user)->get());
// print_r($storageDB->connection('users')->updateById(1788, $user)->get());

print_r('<pre>');
User::connection()->where('id', '=', 1)->get();
print_r('</pre>');
print_r('<pre>');
Product::connection()->where('id', '=', 1)->get();
print_r('</pre>');
print_r('<pre>');
User::connection()->where('id', '=', 1)->get();
print_r('</pre>');

// $storageJSON = (new CreatorStorage())->getStorage('json');
// print_r($storageJSON->connection('users')->getAll()->where('name', '=', 'Nguyen Van A')->get());
// print_r($storageJSON->connection('users')->getById(2)->get());
// print_r($storageJSON->connection('users')->deleteAll()->get());
// print_r($storageJSON->connection('users')->deleteById(4)->get());
// print_r($storageJSON->connection('users')->insert($user)->get());
// print_r($storageJSON->connection('users')->updateById(3, $user)->get());