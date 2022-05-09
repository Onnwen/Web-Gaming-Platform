<?php
$party_id = $_POST['party_id'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$playerIdSql = "SELECT `id` FROM `utenti` WHERE `playing_party` = '" . $party_id . "' ";
$partyDataSql = "SELECT * FROM `partite` WHERE `id` = '" . $party_id . "'";

$playersId = mysqli_fetch_all(mysqli_query($con, $playerIdSql));
$partyData = mysqli_fetch_assoc(mysqli_query($con, $partyDataSql));

$players = array();

$i = 0;
foreach ($playersId as $playerId) {
    $playerIdSql = "SELECT `username` FROM `utenti` WHERE `id` = '" . $playerId[0] . "' ";
    $playerUsername = mysqli_fetch_assoc(mysqli_query($con, $playerIdSql));
    $playerCoordinateSql = "SELECT `latitude`, `longitude` FROM `oggetti` WHERE `id_player` = '" . $playerId[0] . "' AND `id_party` = '" . $party_id . "' ";
    $playerCoordinate = mysqli_fetch_assoc(mysqli_query($con, $playerCoordinateSql));
    array_push($players, array('username' => $playerUsername['username'],
        'id' => $playerId[0],
        'longitude' => floatval($playerCoordinate['longitude']),
        'latitude' => floatval($playerCoordinate['latitude']),
        'index' => $i));
    $i += 1;
}

$result = array();

$result = array('id' => $partyData['id'],
    'started' => date($partyData['creation']),
    'winner' => $partyData['winner_id'],
    'players' => $players);

$output = json_encode($result, JSON_PRETTY_PRINT);
echo $output;
mysqli_close($con);
?>