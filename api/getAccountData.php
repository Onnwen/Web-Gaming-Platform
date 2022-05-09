<?php
$user_id = $_POST['user_id'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$userInfoSql = "SELECT * FROM `utenti` WHERE `id` = '".$user_id."'";
$userWinSql = "SELECT * FROM `partite` WHERE `winner_id` = '".$user_id."'";

$res = mysqli_query($con,$userInfoSql);
$array = mysqli_fetch_array($res);

$result = array();

if ($array['username'] <> null) {
    $winRes = mysqli_query($con,$userWinSql);
    $winArray = mysqli_fetch_array($winRes);
    $totalWin = 0;

    if (is_countable($winArray) && count($winArray)) {
        $totalWin = count($winArray);
    }

    $result = array('id' => $array['id'],
        'username' => $array['username'],
        'password' => $array['password'],
        'win' => $totalWin,
        'playing_party' => $array['playing_party']);
}
else {
    $result = array('id' => "-",
        'username' => "-",
        'win' => "-",
        'playing_party' => $array['playing_party']);
}


$output = json_encode($result, JSON_PRETTY_PRINT);

echo $output;
mysqli_close($con);
?>