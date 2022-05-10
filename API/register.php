<?php
function userId($un) {
    $userExitCon = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');
    $userExistSql = "SELECT * FROM `utenti` WHERE `username` = '".$un."'";
    $res = mysqli_query($userExitCon,$userExistSql);
    $array = mysqli_fetch_array($res);
    mysqli_close($userExitCon);
    return $array['id'];
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

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

$userId = userId($username);
if ($userId <> null) {
    $result = array('created' => false,
        'id' => $userId,
        'status_id' => 0);
}
else {
    if (count_chars($username) > 4 && count_chars($password) > 6) {
        $createUserSql = "INSERT INTO `utenti`(`id`, `username`, `password`, `created_by_ip`) VALUES (UUID(),'" . $username . "','" . $password . "', '" . get_client_ip() . "')";
        mysqli_query($con, $createUserSql);
        $id = userId($username);
        if ($id == null) {
            $result = array('created' => false,
                'id' => null,
                'status_id' => 2);
        } else {
            $result = array('created' => true,
                'id' => $id,
                'status_id' => 1);
        }
    }
    else {
        $result = array('created' => false,
            'id' => null,
            'status_id' => 3);
    }
}

$output = json_encode($result, JSON_PRETTY_PRINT);

echo $output;
mysqli_close($con);
