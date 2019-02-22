<?php
include_once('Database.php');
include_once('DbObject.php');

class User extends DbObject
{
    protected static $db_table = "users";
    protected static $db_table_fields = array('login', 'pass', 'email', 'level', 'admin');
    public $id, $login, $pass, $email, $level, $admin;

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
        $object->login = $the_record["login"];
        $object->pass = $the_record["pass"];
        $object->email = $the_record["email"];
        $object->level = $the_record["level"];
        $object->admin = $the_record["admin"];

        return $object;
    }

    public function setAdmin()
    {
        global $database;

        $sql = "UPDATE " . self::$db_table . " SET admin=" . $this->toggleAdmin() . " WHERE id=" . $this->id;

        return ($database->query($sql)) ? true : false;
    }

    public function toggleAdmin()
    {
        return $this->admin = 1 - $this->admin;
    }

    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }

    public static function getUsernameById($userID)
    {
        global $database;
        $result_set = $database->query("SELECT login FROM " . static::$db_table . " WHERE id=" . $userID);

        $row = mysqli_fetch_assoc($result_set);

        return $row['login'];
    }

    public function increaseLevel()
    {
        global $database;

        $sql = "UPDATE " . self::$db_table . " SET level=" . $this->levelUp() . " WHERE id=" . $this->id;

        return ($database->query($sql)) ? true : false;
    }

    public function levelUp()
    {
        return $this->level=$this->level++;
    }
}