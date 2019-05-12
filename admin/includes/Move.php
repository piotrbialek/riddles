<?php
include_once('Database.php');
include_once('DbObject.php');

class Move extends DbObject
{
    protected static $db_table = "moves";
    protected static $db_table_fields = array('game_id', 'player_id', 'riddle_id');
    public $id, $game_id, $player_id, $riddle_id;

    public static function findById($id)
    {
        $query = "SELECT * FROM " . self::$db_table . " WHERE id=" . $id . " LIMIT 1";
        return static::findOneByQuery($query);
    }

    public static function findOpponentsMove($game_id, $user_id)
    {
        $query = "SELECT * FROM " . self::$db_table . " WHERE (game_id=" . $game_id . " AND player_id != " . $user_id . ") LIMIT 1";
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
        $object->game_id = $the_record["game_id"];
        $object->player_id = $the_record["player_id"];
        $object->riddle_id = $the_record["riddle_id"];
        return $object;
    }

    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }

    public static function checkMoveExist($game_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE game_id=" . $game_id;
        return static::findByQuery($query);
    }

    public static function findByRiddleId($riddle_id)
    {
        $query = "SELECT * FROM " . self::$db_table . " WHERE riddle_id=" . $riddle_id . " LIMIT 1";
        return static::findOneByQuery($query);
    }
}