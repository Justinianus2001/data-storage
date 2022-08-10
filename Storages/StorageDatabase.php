<?php

require_once "../Models/User.php";
require_once "Storage.php";

class StorageDatabase extends Storage
{
    private static $instance = null;
    private $table;
    private $connect;
    private $sql;
    private $haveWhere;

    protected function __construct()
    {
        $this->connect = mysqli_connect(
            getenv('DB_SERVER_NAME'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            getenv('DB_DATABASE'),
        );

        if (!$this->connect) {
            throw new Exception("Connection failed: " . mysqli_connect_error(), 500);
        }
    }

    public static function getInstance() : StorageDatabase
    {
        if (!isset(self::$instance)) {
            self::$instance = new StorageDatabase();
        }

        return self::$instance;
    }

    public function getTableModel() : ?string
    {
        $model = null;
        $words = explode("_", $this->table);

        foreach ($words as $word) {
            $model .= ucfirst(strtolower($word));
        }

        $model = substr($model, 0, -1);
        require_once '../Models/' . $model . '.php';
        return $model;
    }

    public function connection(string $table) : StorageDatabase
    {
        $this->table = $table;
        $this->sql = null;
        $this->haveWhere = false;
        return self::$instance;
    }

    public function disconnection() : void
    {
        $this->table = null;
        $this->sql = null;
        $this->haveWhere = false;
    }

    public function getAll() : StorageDatabase
    {
        try {
            $this->sql .= "SELECT * FROM `" . $this->table . "`";

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function getById(int $id) : StorageDatabase
    {
        try {
            $this->sql .= "SELECT * FROM `" . $this->table . "` WHERE `id` = " . $id;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function deleteAll() : StorageDatabase
    {
        try {
            $this->sql .= "DELETE FROM `" . $this->table . "`";

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function deleteById(int $id) : StorageDatabase
    {
        try {
            $this->sql .= "DELETE FROM `" . $this->table . "` WHERE `id` = " . $id;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function insert(object $model) : StorageDatabase
    {
        try {
            $info = $model->getAll();
            unset($info['id']);

            $this->sql .= "INSERT INTO `" . $this->table . "` (`" . implode('`, `', array_keys($info)) . "`)
                        VALUES ('" . implode("', '", array_values($info)) . "')";

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function updateById(int $id, object $model) : StorageDatabase
    {
        try {
            $info = $model->getAll();
            unset($info['id']);
            $array = [];

            foreach ($info as $key => $value) {
                $array[] = "`" . $key . "` = '" . $value . "'";
            }

            $this->sql .= "UPDATE `" . $this->table . "` 
                        SET " . implode(', ', $array) . "
                        WHERE `id` = " . $id;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function where(string $col, string $cmp, $value) : StorageDatabase
    {
        try {
            if ($this->haveWhere) {
                $this->sql .= " AND";
            } else {
                $this->sql .= " WHERE";
            }
            $this->sql .= " `" . $col  . "` " . $cmp . " " . $value;
            $this->haveWhere = true;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function orWhere(string $col, string $cmp, $value) : StorageDatabase
    {
        try {
            $this->sql .= " OR `" . $col  . "` " . $cmp . " " . $value;
            $this->haveWhere = true;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function get()
    {
        try {
            $query = $this->connect->query($this->sql);

            if (isset($query->num_rows)) {
                $model = $this->getTableModel();
                $res = [];

                while ($row = $query->fetch_assoc()) {
                    $res[] = $model::create($row);
                }

                return $res;
            }

            $this->disconnection();

            return true;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }
}