<?php
function userId($un) {
    $userExitCon = mysqli_connect('localhost','root','','gioco');
    $userExistSql = "SELECT * FROM `utenti` WHERE `username` = '".$un."'";
    $res = mysqli_query($userExitCon,$userExistSql);
    $array = mysqli_fetch_array($res);
    mysqli_close($userExitCon);
    return $array['id'];
}

$username = $_POST['username'];
$password = $_POST['password'];

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco');

header("Access-Control-Allow-Origin: *");

$userId = userId($username);
if ($userId <> 0) {
    $result = array('created' => boolval(false),
        'id' => $userId,
        'status_id' => 0);
}
else {
    if (count_chars($username) > 4 && count_chars($password) > 6) {
        $createUserSql = "INSERT INTO `utenti`(`id`, `username`, `password`) VALUES (UUID(),'" . $username . "','" . $password . "')";
        mysqli_query($con, $createUserSql);
        $id = userId($username);
        if ($id == 0) {
            $result = array('created' => boolval(false),
                'id' => null,
                'status_id' => 2);
        } else {
            $result = array('created' => boolval(true),
                'id' => $id,
                'status_id' => 1);
        }
    }
    else {
        $result = array('created' => boolval(false),
            'id' => null,
            'status_id' => 3);
    }
}

$output = json_encode($result, JSON_PRETTY_PRINT);

echo $output;
mysqli_close($con);
?>
