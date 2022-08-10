<?php

require_once "Model.php";

class User extends Model
{
    protected $table = 'users';
    protected static $type = 'database';

    private $id;
    private $name;
    private $phone;
    private $email;
    private $password;

    public static function create(array $array) : User
    {
        $model = new User();
        $model->id = $array['id'] ?? null;
        $model->name = $array['name'];
        $model->phone = $array['phone'];
        $model->email = $array['email'];
        $model->password = $array['password'];
        return $model;
    }

    public function getAll() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}