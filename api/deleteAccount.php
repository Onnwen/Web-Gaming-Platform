<?php
$username = $_POST['username'];
$password = $_POST['password'];

$con = mysqli_connect('localhost','root','','gioco');
$sql = "DELETE FROM `utenti` WHERE `username` = '".$username."' AND `password` = '".$password."'";

header("Access-Control-Allow-Origin: *");

$res = mysqli_query($con,$sql);

echo "done";
mysqli_close($con);
?>