<?php
include_once('Database.php');
include_once('DbObject.php');

class Player extends DbObject
{
    protected static $db_table = "players";
    protected static $db_table_fields = array('user_id', 'game_id','score');
    public $id, $user_id, $game_id, $score;


    public static function findById($id)
    {
        $query = "SELECT * FROM " . self::$db_table . " WHERE id=".$id." LIMIT 1";
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
        $object->user_id = $the_record["user_id"];
        $object->game_id = $the_record["game_id"];
        $object->score = $the_record["score"];
        return $object;
    }


    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }

    public static function findMyGames($user_id)
    {
        $query="SELECT * FROM ". static::$db_table ." WHERE user_id=".$user_id;
        return static::findByQuery($query);
    }


    public static function checkIfGameExists($user_id)
    {
        $query="SELECT * FROM ". static::$db_table ." WHERE user_id=".$user_id;
        return static::findByQuery($query);
    }

    public static function checkGamePlayers($game_id)
    {
        $query="SELECT * FROM ". static::$db_table ." WHERE game_id=".$game_id;
        return static::findByQuery($query);
    }
}