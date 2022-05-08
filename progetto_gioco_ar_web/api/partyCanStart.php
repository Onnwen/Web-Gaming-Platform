<?php
$party = $_POST['party_id'];

header("Access-Control-Allow-Origin: *");

$con = mysqli_connect('localhost', 'root', '', 'gioco');

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
