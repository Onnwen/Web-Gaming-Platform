<?php
$username = $_POST['username'];
$password = $_POST['password'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','on','passwordSegretaDatabase','gioco');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$sql = "SELECT * FROM `utenti` WHERE `username` = '".$username."' AND `password` = '".$password."'";

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