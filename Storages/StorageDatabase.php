<?php

require_once "StorageFactory.php";
require_once "../Models/User.php";

class StorageDatabase extends StorageFactory
{
    private static $connect = null;

    public static function connection(array $storage) : mysqli
    {
        if (!isset(self::$connect) || !mysqli_ping(self::$connect)) {
            self::$connect = mysqli_connect($storage['server_name'], $storage['username'],
                                        $storage['password'], $storage['database']);
        }

        if (!self::$connect) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return self::$connect;
    }

    public static function disconnection() : void
    {
        mysqli_close(self::$connect);
    }

    public static function getAll() : array
    {
        try {
            $sql = "SELECT * FROM `users`";
            $query = self::$connect->query($sql);
            $res = [];

            while ($row = $query->fetch_assoc()) {
                $res[] = new User($row['name'], $row['phone'], $row['email'], $row['password']);
            }

            return $res;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function getById(int $id) : ?User
    {
        try {
            $sql = "SELECT * FROM `users` WHERE `id` = " . $id;
            $query = self::$connect->query($sql);
            $res = null;

            while ($row = $query->fetch_assoc()) {
                $res = new User($row['name'], $row['phone'], $row['email'], $row['password']);
            }

            return $res;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function deleteAll() : bool
    {
        try {
            $sql = "DELETE FROM `users`";
            $query = self::$connect->query($sql);

            return $query;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function deleteById(int $id) : bool
    {
        try {
            $sql = "DELETE FROM `users` WHERE `id` = " . $id;
            $query = self::$connect->query($sql);

            return $query;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function insert(User $user) : bool
    {
        try {
            $sql = "INSERT INTO `users` (`name`, `phone`, `email`, `password`)
                    VALUES ('" . $user->getName() . "',
                            '" . $user->getPhone() . "',
                            '" . $user->getEmail() . "',
                            '" . $user->getPassword() . "')";
            $query = self::$connect->query($sql);

            return $query;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function updateById(int $id, User $user) : bool
    {
        try {
            $sql = "UPDATE `users` 
                    SET `name`  = '" . $user->getName() . "',
                        `phone` = '" . $user->getPhone() . "',
                        `email` = '" . $user->getEmail() . "',
                        `password` = '" . $user->getPassword() . "'
                    WHERE `id` = " . $id;
            $query = self::$connect->query($sql);

            return $query;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }
}