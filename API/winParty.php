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

$sql = "UPDATE `partite` SET `winner_id` = '".$player_id."' WHERE `id` = '".$party_id."'";

$res = mysqli_query($con,$sql);

echo "done";
mysqli_close($con);
