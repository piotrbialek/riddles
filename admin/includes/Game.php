<?php
include_once('Database.php');
include_once('DbObject.php');

class Game extends DbObject
{
    protected static $db_table = "games";
    protected static $db_table_fields = array('player_started_id', 'result_id');
    public $id, $player_started_id, $result_id;

    public static function findById($id)
    {
        $query = "SELECT * FROM " . self::$db_table . " WHERE id=" . $id . " LIMIT 1";
        return static::findOneByQuery($query);
    }

    public static function findOneByQuery($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        $object = static::instantiation($row);
        return $object;
    }

    public static function findByQuery($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();

        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    public static function instantiation($the_record)
    {
        $calling_class = get_called_class();
        $object = new $calling_class;
        $object->id = $the_record["id"];
        $object->player_started_id = $the_record["player_started_id"];
        $object->result_id = $the_record["result_id"];
        return $object;
    }

    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }
}