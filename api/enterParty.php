<?php
function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function totalPlayersInParty($party, $partys)
{
    $totalP = 0;
    foreach ($partys as $p) {
        if ($p == $party) {
            $totalP++;
        }
    }
    return $totalP;
}

$player_id = $_POST['player_id'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$con = mysqli_connect('52.47.52.89','onn','passwordSegretaDatabase','gioco1');

if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$userInfoSql = "SELECT * FROM `utenti` WHERE `id` = '" . $player_id . "'";
$userInfo = mysqli_fetch_array(mysqli_query($con, $userInfoSql));

$result = array();

if ($userInfo["playing_party"] == null) {
    $runningPartySql = "SELECT `id` FROM `partite` WHERE `winner_id` IS NULL;";
    $runningParty = mysqli_fetch_assoc(mysqli_query($con, $runningPartySql));
    $partyUserSql = "SELECT `playing_party` FROM `utenti` WHERE `playing_party` IS NOT NULL";
    $partyUser = mysqli_fetch_assoc(mysqli_query($con, $partyUserSql));

    $partyFound = false;

    foreach ((array)$runningParty as $party) {
        if (totalPlayersInParty($party, $partyUser) < 2) {
            $partyFound = true;

            $updateParty = "UPDATE `utenti` SET `playing_party`='" . $party . "' WHERE id ='" . $player_id . "'";
            $updateObject = "INSERT INTO `oggetti`(`id_player`, `id_party`, `latitude`, `longitude`) VALUES ('" . $player_id . "','" . $party . "','" . $latitude . "','" . $longitude . "')";
            mysqli_query($con, $updateParty);
            mysqli_query($con, $updateObject);

            $result = array('status' => 1,
                'party_id' => $party
            );
        }
    }

    if ($partyFound == false) {
        $partyUUID = guidv4();
        $newParty = "INSERT INTO `partite`(`id`) VALUES ('" . $partyUUID . "')";
        mysqli_query($con, $newParty);

        $updateParty = "UPDATE `utenti` SET `playing_party`='" . $partyUUID . "' WHERE id ='" . $player_id . "'";
        $updateObject = "INSERT INTO `oggetti`(`id_player`, `id_party`, `latitude`, `longitude`) VALUES ('" . $player_id . "','" . $partyUUID . "','" . $latitude . "','" . $longitude . "')";
        mysqli_query($con, $updateParty);
        mysqli_query($con, $updateObject);


        $result = array('status' => 2,
            'party_id' => $partyUUID);
    }
} else {
    $result = array('status' => 0,
        'party_id' => $userInfo["playing_party"]
    );
}

$output = json_encode($result, JSON_PRETTY_PRINT);
echo $output;
mysqli_close($con);
?>
