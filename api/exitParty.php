<?php
$player_id = $_POST['player_id'];
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

$updateUserSql = "UPDATE `utenti` SET `playing_party`= null WHERE `id` ='".$player_id."'";
mysqli_query($con,$updateUserSql);
$deleteObjectSql = "DELETE FROM `oggetti` WHERE `id_party` = '" . $party_id . "' and `id_player` ='".$player_id."'";
mysqli_query($con, $deleteObjectSql);

$partyDataSql = "SELECT * FROM `partite` WHERE `id` = '" . $party_id . "'";
$partyData = mysqli_fetch_assoc(mysqli_query($con, $partyDataSql));

if ($partyData['winner_id'] == null) {
    $partyUserSql = "SELECT `playing_party` FROM `utenti` WHERE `playing_party` IS NOT NULL";
    $partyUser = mysqli_fetch_all(mysqli_query($con, $partyUserSql));
    if (count($partyUser) < 1) {
        $deletePartySql = "DELETE FROM `partite` WHERE `id` = '" . $party_id . "'";
        mysqli_query($con, $deletePartySql);
    }
}

$result = array('done' => boolval(true));
$output = json_encode($result, JSON_PRETTY_PRINT);

mysqli_close($con);
?>