<?php
$username = $_GET['username'];
$password = $_GET['password'];

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco');
$sql = "SELECT * FROM `utenti` WHERE `username` = '".$username."' AND `password` = '".$password."'";

header("Access-Control-Allow-Origin: *");

$res = mysqli_query($con,$sql);
$array = mysqli_fetch_array($res);
$result = array();

if ($array['id'] == 0) {
    $result = array('exist' => boolval(false),
        'id' => null);
}
else {
    $result = array('exist' => boolval(true),
        'id' => $array['id']);
}
$output = json_encode($result, JSON_PRETTY_PRINT);

echo $output;
mysqli_close($con);
?>