<?php
include_once('Database.php');
include_once('DbObject.php');

class Player extends DbObject
{
    protected static $db_table = "players";
    protected static $db_table_fields = array('user_id', 'game_id', 'score');
    public $id, $user_id, $game_id, $score;

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
        $query = "SELECT * FROM " . static::$db_table . " WHERE user_id=" . $user_id;
        return static::findByQuery($query);
    }

    public static function checkIfGameExists($user_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE user_id=" . $user_id;
        return static::findByQuery($query);
    }

    public static function checkGamePlayers($game_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE game_id=" . $game_id;
        return static::findByQuery($query);
    }

    public static function findGamePlayerId($user_id, $game_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE game_id=" . $game_id . " AND user_id=" . $user_id;
        return static::findOneByQuery($query);
    }

    public static function getPlayerScore($user_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE  user_id=" . $user_id;
        $score = 0;
        $player_scores = self::findByQuery($query);
        foreach ($player_scores as $player_score) :
            $score += $player_score->score;
        endforeach;
        return $score;
    }

    public static function getPlayerWins($user_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE  user_id=" . $user_id . " AND score>0";
        return count(self::findByQuery($query));
    }

    public static function getPlayerLoses($user_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE  user_id=" . $user_id . " AND score<0";
        return count(self::findByQuery($query));
    }

    public static function getPlayerGames($user_id)
    {
        $query = "SELECT * FROM " . static::$db_table . " WHERE  user_id=" . $user_id;
        return count(self::findByQuery($query));
    }

    public static function getPlayerRecommendationData($user_id)
    {
        $player_data = array();
        $wins = Player::getPlayerWins($user_id);
        $looses = Player::getPlayerLoses($user_id);
        $games = Player::getPlayerGames($user_id);
        $wins_percentage = 0;
        $looses_percentage = 0;
        if ($games > 0) {
            $wins_percentage = round(($wins / $games), 3) * 100;
            $looses_percentage = round(($looses / $games), 3) * 100;
        }
        $player_data[0] = $wins_percentage;
        $player_data[1] = $looses_percentage;
        $player_data[2] = $games;
        return $player_data;
    }

    public static function similarityDistance($matrix, $person1, $person2)
    {
        $similar = array();
        $sum = 0;

        foreach ($matrix[$person1] as $key => $value) {
            if (array_key_exists($key, $matrix[$person2])) {
                $similar[$key] = 1;
            }
        }

        if ($similar == 0) {
            return 0;
        }

        foreach ($matrix[$person1] as $key => $value) {
            if (array_key_exists($key, $matrix[$person2])) {
                $sum = $sum + pow($value - $matrix[$person2][$key], 2);
            }
        }
        return 1 / (1 + sqrt($sum));

    }

    public static function similarity(array $vec1, array $vec2)
    {
        $dotProduct = self::dotProduct($vec1, $vec2);
        $denominator = self::absoluteVector($vec1) * self::absoluteVector($vec2);
        return $dotProduct / $denominator;
    }

    protected static function dotProduct(array $vec1, array $vec2)
    {
        $result = 0;
        foreach (array_keys($vec1) as $key1) {
            foreach (array_keys($vec2) as $key2) {
                if ($key1 === $key2) $result += $vec1[$key1] * $vec2[$key2];
            }
        }
        return $result;
    }

    protected static function absoluteVector(array $vec)
    {
        $result = 0;
        foreach (array_values($vec) as $value) {
            $result += pow($value, 2);
        }
        return sqrt($result);
    }
}