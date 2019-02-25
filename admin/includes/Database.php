<?php

require_once ($_SERVER['DOCUMENT_ROOT']."/projekt/config.php");

class Database
{
    public $connection;
    public $db;

    function __construct()
    {
        $this->db = $this->openDbConnection();
    }

    public function openDbConnection()
    {
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        mysqli_query($this->connection, "SET NAMES 'utf8'");

        if ($this->connection->connect_errno) {
            die("conn problem: ".$this->connection->connect_error);
        }
        return $this->connection;
    }

    public function query($sql)
    {
        $result = $this->db->query($sql);
        $this->confirmQuery($result);
        return $result;
    }

    private function confirmQuery($result)
    {
        if (!$result) {
            die("query failed: ".$this->db->error);
        }
    }

    public function escapeString($string)
    {
        return $this->db->real_escape_string($string);
    }

    public function theInsertId()
    {
//        return $this->db->insert_id;
        return mysqli_insert_id($this->connection);
    }
}

$database = new Database();

