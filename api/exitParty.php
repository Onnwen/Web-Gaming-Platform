<?php
$player_id = $_POST['player_id'];
$party_id = $_POST['party_id'];

header("Access-Control-Allow-Origin: *");

$con = mysqli_connect('localhost','root','','gioco');
$updateUserSql = "UPDATE `utenti` SET `playing_party`= null WHERE `id` ='".$player_id."'";
mysqli_query($con,$updateUserSql);
$deleteObjectSql = "DELETE FROM `oggetti` WHERE `id_party` = '" . $party_id . "' and `id_player` ='".$player_id."'";
mysqli_query($con, $deleteObjectSql);

$partyDataSql = "SELECT * FROM `partita` WHERE `id` = '" . $party_id . "'";
$partyData = mysqli_fetch_assoc(mysqli_query($con, $partyDataSql));

if ($partyData['winner_id'] == null) {
    $partyUserSql = "SELECT `playing_party` FROM `utenti` WHERE `playing_party` IS NOT NULL";
    $partyUser = mysqli_fetch_all(mysqli_query($con, $partyUserSql));
    if (count($partyUser) < 1) {
        $deletePartySql = "DELETE FROM `partita` WHERE `id` = '" . $party_id . "'";
        mysqli_query($con, $deletePartySql);
    }
}

echo "done";
mysqli_close($con);
?>