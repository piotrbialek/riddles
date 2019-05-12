<?php
session_start();

include('../projekt/admin/includes/User.php');
include('../projekt/admin/includes/Player.php');

$users = User::findAll();
$matrix = array();
$results = ['level', 'wins', 'looses'];

function similarityDistancee($matrix, $person1, $person2)
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


function getRecommendation($matrix, $person)
{
    $simPersons = array();
    foreach ($matrix as $otherPerson => $value) {
        if ($otherPerson != $person) {
            $sim = similarityDistancee($matrix, $person, $otherPerson);
            $simPersons[$otherPerson] = $sim;
        }
    }
    return $simPersons;
}


?>


<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<table>
    <thead class='table_header'>
    <th>id</th>
    <th>level</th>
    <th>% W</th>
    <th>% L</th>
    <th>games</th>
    <th>wins</th>
    <th>looses</th>
    </thead>
    <tbody>
    <?php foreach ($users as $user) : ?>
        <?php
        $wins = Player::getPlayerWins($user->id);
        $looses = Player::getPlayerLoses($user->id);
        $games = Player::getPlayerGames($user->id);
        $wins_percentage = 0;
        $looses_percentage = 0;
        if ($games > 0) {
            $wins_percentage = round(($wins / $games), 3)*100;
            $looses_percentage = round(($looses / $games), 3)*100;
        }


        ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->level;
                $matrix[$user->id]['level'] = $user->level; ?></td>
            <td><?php echo $wins_percentage;
                $matrix[$user->id]['wins'] = $wins_percentage; ?></td>
            <td><?php echo $looses_percentage;
                $matrix[$user->id]['looses'] = $looses_percentage; ?></td>
            <td><?php echo $games;
                $matrix[$user->id]['games'] = $games; ?></td>
            <td><?php echo $wins;?></td>
            <td><?php echo $looses;?></td>

        </tr>

        <?php
        $matrix[$user->id]['level'] = $user->level;
        $matrix[$user->id]['wins'] = $wins_percentage;
        $matrix[$user->id]['looses'] = $looses_percentage;
        $matrix[$user->id]['games'] = $games;
//        echo $user->id." - ";

//        foreach ($results as $result):
//            $matrix[$user->id][$result]=$result;

        //echo $matrix[$user->id][$result];
//            echo " ";
//        endforeach;
//        echo "<br>";
        ?>

    <?php endforeach; ?>
    </tbody>
</table>
<?php

//$recommendations = getRecommendation($matrix, 1);
////var_dump($recommendations);
//foreach ($recommendations as $key => $value):
//    echo $key . " - ";
//    echo $value;
//    echo "<br>";
//endforeach;
//echo "<br>";
//echo "SIMILARITY:<br>";
//echo similarityDistancee($matrix, 51, 34);
echo "<br>";
echo "<br>";

$playerTest = Player::getPlayerRecommendationData(57);
$playerData51 = Player::getPlayerRecommendationData(51);
$playerData1 = Player::getPlayerRecommendationData(1);
$playerData32 = Player::getPlayerRecommendationData(32);
$playerData34 = Player::getPlayerRecommendationData(34);
$playerData53 = Player::getPlayerRecommendationData(53);



$cosineSimT51 = Player::similarity($playerTest, $playerData51);
$cosineSimT1 = Player::similarity($playerTest, $playerData1);
$cosineSimT32 = Player::similarity($playerTest, $playerData32);
$cosineSimT34 = Player::similarity($playerTest, $playerData34);
$cosineSimT53 = Player::similarity($playerTest, $playerData53);
$cosineSimTT = Player::similarity($playerTest, $playerTest);


echo "<br>";
echo "cosineSim Test (57) - 1: " . $cosineSimT1;
echo "<br>";
echo "cosineSim Test (57) - 32: " . $cosineSimT32;
echo "<br>";
echo "cosineSim Test (57) - 34: " . $cosineSimT34;
echo "<br>";

echo "cosineSim Test (57) - 51: " . $cosineSimT51;
echo "<br>";
echo "cosineSim Test (57) - 53: " . $cosineSimT53;
echo "<br>";

echo "cosineSim Test-Test: " . $cosineSimTT;


?>



