<?php

namespace app\Core\db;

use app\Core\Application;
use app\Core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
                    VALUES (" .implode(',', $params) . ")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute",$this->$attribute);
        }
        $statement->execute();
        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function findOne($where) // [email => example@com, firstname => name]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        // SELECT * FROM $tableName WHERE email = :email and firstname = :firstname;
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }


    public function rules(): array
    {
        // TODO: Implement rules() method.
    }
}