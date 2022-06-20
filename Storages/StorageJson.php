<?php

require_once "StorageFactory.php";
require_once "../Models/User.php";

class StorageJson extends StorageFactory
{
    private static $connect = null;
    private static $fileJson = null;

    public static function updateJson() : void
    {
        file_put_contents(__DIR__ . '/../public/' . self::$fileJson,
                            json_encode(self::$connect, JSON_PRETTY_PRINT));
    }

    public static function connection(array $storage) : array
    {
        try {
            self::$fileJson = $storage['file'];

            if (!isset(self::$connect)) {
                self::$connect = json_decode(file_get_contents(__DIR__ . '/../public/' . $storage['file']), true);
            }

            return self::$connect;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function disconnection() : void
    {
        self::$connect = null;
    }

    public static function getAll() : array
    {
        try {
            $res = [];

            foreach (self::$connect as $row) {
                if (isset($row)) {
                    $res[] = new User($row['name'], $row['phone'], $row['email'], $row['password']);
                }
            }

            return $res;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function getById(int $id) : ?User
    {
        try {
            $res = null;
            $row = self::$connect[$id] ?? null;

            if (isset($row)) {
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
            foreach (self::$connect as $key => &$value) {
                $value = null;
            }

            self::updateJson();

            return true;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function deleteById(int $id)
    {
        try {
            if ($id <= count(self::$connect) && $id > 0) {
                self::$connect[$id] = null;
            }

            self::updateJson();

            return true;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function insert(User $user) : bool
    {
        try {
            $id = count(self::$connect);

            $res = [];
            $res['name'] = $user->getName();
            $res['phone'] = $user->getPhone();
            $res['email'] = $user->getEmail();
            $res['password'] = $user->getPassword();

            self::$connect[$id] = $res;

            self::updateJson();

            return true;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }

    public static function updateById(int $id, $user)
    {
        try {
            if ($id <= count(self::$connect) && $id > 0) {
                $res = [];
                $res['name'] = $user->getName();
                $res['phone'] = $user->getPhone();
                $res['email'] = $user->getEmail();
                $res['password'] = $user->getPassword();

                self::$connect[$id] = $res;
            }

            self::updateJson();

            return true;
        } catch (Throwable $th) {
            die("Connection failed: " . $th->getMessage());
        }
    }
}