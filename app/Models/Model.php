<?php


namespace App\Models;

use App\Database\DB;
use PDO;
use PDOException;

class Model
{

    protected $table = '';
    protected $id = 'id';


    public function __construct($attrs = [])
    {
        if (count($attrs)) {
            foreach ($attrs as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public static function getTable()
    {
        $class = get_called_class();

        $table = (new $class)->table;

        return $table;
    }
    public static function getId()
    {
        $class = get_called_class();

        $id = (new $class)->id;

        return $id;
    }

    public static function create($data)
    {

        $pdo = DB::connection();

        $query = "INSERT INTO " . self::getTable() . " ";

        $columns = "(";
        $values = "values(";

        foreach ($data as $key => $value) {
            $columns .= "$key,";
            $values .= ":$key,";
        }



        $columns = trim($columns, ',') . ")";
        $values = trim($values, ',') . ")";

        $query .= $columns . " " . $values;

        $stmt = $pdo->prepare($query);


        $params = [];
        foreach ($data as $key => $value) {
            $params[":$key"] = $value;
        }

        $e = $stmt->execute($params);

        return $e;
    }

    public static function getAll()
    {
        $pdo = DB::connection();

        $query = "SELECT * FROM " . self::getTable();

        $stmt = $pdo->prepare($query);

        $e = $stmt->execute();

        if (!$e) {
            return false;
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public static function where_in(string $column, array $data)
    {
        $query = "SELECT * FROM " . self::getTable() . " where $column in (";

        for ($i = 0; $i < count($data) - 1; $i++) {
            $query .= "?, ";
        }

        $query .= "?)";



        $pdo = DB::connection();

        $stmt = $pdo->prepare($query);

        if (!$stmt->execute($data)) {
            return false;
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public static function getLastRecord()
    {
        $pdo = DB::connection();

        $query = "SELECT * FROM " . self::getTable() . " order by " . self::getId() . " desc limit 1";

        $stmt = $pdo->prepare($query);

        if ($stmt->execute()) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data[0];
        }
        return false;
    }

    public static function where_and($conditions)
    {
    }
    public static function where($conditions)
    {
        $condition_text = '';

        foreach ($conditions as $c) {
            if (is_string($c[1])) {
                $condition_text .= " " . $c[0] . " = '" . $c[1] . "' and";
            } else {
                $condition_text .= " " . $c[0] . " = " . $c[1] . " and";
            }
        }

        $condition_text = trim($condition_text, 'and');


        $query = "select * from " . self::getTable() . " where " . $condition_text;

        $pdo = DB::connection();

        $stmt = $pdo->prepare($query);

        if (!$stmt->execute()) {
            return false;
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public static function query($query)
    {

        $pdo = DB::connection();

        try {
            $stmt = $pdo->prepare($query);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function select($query)
    {

        $pdo = DB::connection();
        try {

            $stmt = $pdo->prepare($query);

            if (!$stmt->execute()) {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $query = "SELECT * FROM " . self::getTable() . " WHERE " . self::getId() . " = :id limit 1";

        $pdo = DB::connection();

        $stmt = $pdo->prepare($query);

        $e = $stmt->execute([":id" => $id]);

        if (!$e) {
            return false;
        }

        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        return $record;
    }

    public static function delete($id)
    {
        $query = "DELETE FROM " . self::getTable() . " WHERE " . self::getId() . " = :id";

        $pdo = DB::connection();

        try {
            $stmt = $pdo->prepare($query);
            return $stmt->execute([":id" => $id]);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
