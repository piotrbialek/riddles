<?php

class DbObject
{
    protected function properties()
    {

//        return get_object_vars($this);
        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;
    }


    protected function cleanProperties()
    {

        global $database;

        $cleanProperties = array();

        foreach ($this->properties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value);
        }

        return $cleanProperties;

    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }


    public function create()
    {

        global $database;

        $properties = $this->cleanProperties();

        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->theInsertId();
            return true;
        } else {
            return false;
        }

    }


    public function update()
    {
        global $database;

        $properties = $this->cleanProperties();
        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }


        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escapeString($this->id);

        $database->query($sql);
//        var_dump(mysqli_affected_rows($database->connection));
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {

        global $database;

        $sql = "DELETE FROM  " . static::$db_table;
        $sql .= " WHERE id= " . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    public static function countAll()
    {

        global $database;

        $sql = "SELECT count(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);

    }
}