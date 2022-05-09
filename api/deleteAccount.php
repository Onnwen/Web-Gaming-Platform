<?php
$username = $_POST['username'];
$password = $_POST['password'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$sql = "DELETE FROM `utenti` WHERE `username` = '".$username."' AND `password` = '".$password."'";

$res = mysqli_query($con,$sql);

echo "done";
mysqli_close($con);
?>