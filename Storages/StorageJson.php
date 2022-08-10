<?php

require_once "Storage.php";
require_once "../Models/User.php";

class StorageJson extends Storage
{
    private static $instance = null;
    private $table;
    private $query;
    private $typeQuery;

    protected function __construct()
    {
        if (!is_dir(getenv('JSON_STORAGE'))) {
            throw new Exception("Connection failed: Json Storage not found", 500);
        }
    }

    public static function getInstance() : StorageJson
    {
        if (!isset(self::$instance)) {
            self::$instance = new StorageJson();
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

    public function getJson() : ?array
    {
        return json_decode(file_get_contents(getenv('JSON_STORAGE') . "/" . $this->table . ".json"), true);
    }

    public function updateJson(array $data) : void
    {
        file_put_contents(getenv('JSON_STORAGE') . "/" . $this->table . ".json",
                            json_encode($data, JSON_PRETTY_PRINT));
    }

    public function connection(string $table) : StorageJson
    {
        $this->table = $table;
        $this->query = [];
        $this->typeQuery = null;
        return self::$instance;
    }

    public function disconnection() : void
    {
        $this->table = null;
        $this->query = null;
        $this->typeQuery = null;
    }

    public function getAll() : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'get';

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function getById(int $id) : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'get';
            $res = [];

            foreach ($this->query as $row) {
                if (count($row) > 1 && $row['id'] == $id) {
                    $res[] = $row;
                    break;
                }
            }

            $this->query = $res;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function deleteAll() : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'delete';

            foreach ($this->query as &$row) {
                if (isset($row)) {
                    $id = $row['id'];
                    $row = [];
                    $row['id'] = $id;
                }
            }

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function deleteById(int $id) : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'delete';

            foreach ($this->query as &$row) {
                if (isset($row) && $row['id'] == $id) {
                    $row = [];
                    $row['id'] = $id;
                    break;
                }
            }

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function insert(object $model) : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'update';
            $info = $model->getAll();

            $id = (end($this->query)['id'] ?? 0) + 1;
            $info['id'] = $id;
            $this->query[] = $info;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function updateById(int $id, object $model) : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'update';
            $info = $model->getAll();
            $info['id'] = $id;

            foreach ($this->query as &$row) {
                if (count($row) > 1 && $row['id'] == $id) {
                    $row = $info;
                    break;
                }
            }

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function where(string $col, string $cmp, $value) : StorageJson
    {
        try {
            $this->query = $this->getJson();
            $this->typeQuery = 'update';
            $res = [];

            foreach ($this->query as &$row) {
                if (($cmp == '=' && $row[$col] == $value)
                || ($cmp == '<>' && $row[$col] != $value)
                || ($cmp == 'LIKE' && strpos($row[$col], $value))) {
                    $res[] = $row;
                }
            }

            $this->query = $res;

            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function orWhere(string $col, string $cmp, $value) : StorageJson
    {
        try {
            return self::$instance;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }

    public function get()
    {
        try {
            $model = $this->getTableModel();

            switch ($this->typeQuery) {
                case 'get':
                    $res = [];
                    foreach ($this->query as $row) {
                        if (count($row) > 1) {
                            $res[] = $model::create($row);
                        }
                    }
                    break;
                case 'delete':
                case 'update':
                    $this->updateJson($this->query);
                    break;

            }

            $this->disconnection();

            return true;
        } catch (Throwable $th) {
            throw new Exception("Connection failed: " . $th->getMessage(), 500);
        }
    }
}