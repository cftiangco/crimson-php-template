<?php

class BaseModel
{
    private $connection;
    public $tableName;

    public function __construct()
    {
        require_once "./config/database.php";
        $this->connection = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchAll() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $this->tableName ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($sql);
        $statement->execute(array_values($data));
        return $this->connection->lastInsertId();
    }

    public function select($conditions = [], $columns = '*')
    {
        $whereClause = '';
        $params = [];

        if (!empty($conditions)) {
            $whereClause = ' WHERE ';
            $conditionsArr = [];

            foreach ($conditions as $column => $value) {
                $conditionsArr[] = "$column = ?";
                $params[] = $value;
            }

            $whereClause .= implode(' AND ', $conditionsArr);
        }

        $sql = "SELECT $columns FROM $this->tableName" . $whereClause;
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($conditions, $data)
    {
        $setClause = '';
        $params = [];

        foreach ($data as $column => $value) {
            $setClause .= "$column = ?, ";
            $params[] = $value;
        }

        $setClause = rtrim($setClause, ', ');

        $whereClause = ' WHERE ';
        $conditionsArr = [];

        foreach ($conditions as $column => $value) {
            $conditionsArr[] = "$column = ?";
            $params[] = $value;
        }

        $whereClause .= implode(' AND ', $conditionsArr);

        $sql = "UPDATE $this->tableName SET $setClause" . $whereClause;
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement->rowCount();
    }

    public function delete($conditions)
    {
        $whereClause = ' WHERE ';
        $params = [];
        $conditionsArr = [];

        foreach ($conditions as $column => $value) {
            $conditionsArr[] = "$column = ?";
            $params[] = $value;
        }

        $whereClause .= implode(' AND ', $conditionsArr);

        $sql = "DELETE FROM $this->tableName" . $whereClause;
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement->rowCount();
    }
}