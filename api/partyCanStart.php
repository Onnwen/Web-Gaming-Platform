<?php
$party = $_POST['party_id'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$result = array();

$partyUserSql = "SELECT `playing_party` FROM `utenti` WHERE `playing_party` IS NOT NULL";
$partyUser = mysqli_fetch_all(mysqli_query($con, $partyUserSql));

if (count($partyUser) > 1) {
    $result = array('canStart' => true,
        'party_id' => $party
    );
}
else {
    $result = array('canStart' => false,
        'party_id' => $party
    );
}

$output = json_encode($result, JSON_PRETTY_PRINT);
echo $output;
mysqli_close($con);
?>
