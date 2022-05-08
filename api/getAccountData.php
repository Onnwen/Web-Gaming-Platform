<?php
$user_id = $_POST['user_id'];

$con = mysqli_connect('localhost','root','','gioco');
$userInfoSql = "SELECT * FROM `utenti` WHERE `id` = '".$user_id."'";
$userWinSql = "SELECT * FROM `partita` WHERE `winner_id` = '".$user_id."'";

header("Access-Control-Allow-Origin: *");

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