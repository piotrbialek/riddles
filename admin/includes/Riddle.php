<?php
include_once('Database.php');
include_once('DbObject.php');

class Riddle extends DbObject
{
    protected static $db_table = "riddles";
    protected static $db_table_fields = array('category', 'description', 'riddle', 'riddle_level', 'author_id', 'accepted', 'solved', 'in_match');
    public $id, $category, $description, $riddle, $riddle_level, $author_id, $accepted, $solved, $in_match;

    public static function drawRiddle($currentLevel)
    {
        $query = "SELECT * FROM " . Riddle::$db_table . " WHERE accepted=1 and riddle_level=" . $currentLevel . " ORDER BY RAND() LIMIT 1";
        return static::findOneByQuery($query);
    }

    public static function findById($id)
    {
        $query = "SELECT * FROM " . Riddle::$db_table . " WHERE id=" . $id . " LIMIT 1";
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
        $object->category = $the_record["category"];
        $object->description = $the_record["description"];
        $object->riddle = $the_record["riddle"];
        $object->author_id = $the_record["author_id"];
        $object->riddle_level = $the_record["riddle_level"];
        $object->accepted = $the_record["accepted"];
        $object->solved = $the_record["solved"];
        $object->in_match = $the_record["in_match"];

        return $object;
    }

    public function acceptRiddle()
    {
        global $database;

        $sql = "UPDATE " . self::$db_table . " SET accepted=" . $this->toggleAccept() . " WHERE id=" . $this->id;

        return ($database->query($sql)) ? true : false;
    }

    public function toggleAccept()
    {
        return $this->accepted = 1 - $this->accepted;
    }

    public static function findMyRiddles($userID)
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table . " WHERE author_id=" . $userID);
    }

    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }

    public function riddleCompleted($result)
    {
        $this->in_match = 0;
        return $this->save();
    }

    public static function findIfSolved($userID)
    {
        return static::findOneByQuery("SELECT * FROM " . static::$db_table . " WHERE author_id=" . $userID);
    }
}