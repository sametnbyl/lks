<?php
include "connect.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
} else {
    $id = $_SESSION["id"];
}

$user = $db->query("SELECT * FROM users WHERE u_id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
$l_lab = 116;

if ($user["u_status"] == "in") {
    header("Location: /lks/?err=alreadyInside");
} else {
    /*
    if ($user["u_status116"] == "in") {

        $inLab = $db->query("SELECT count(*) FROM users WHERE u_status116 = 'in'")->fetch(PDO::FETCH_ASSOC);

        $l_type = 2;
        $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Labdan çıktı.";
        $l_data = $id;
        $l_date = date("Y-m-d H:i:s");
        $goLog = $db->prepare("INSERT INTO logs SET
        l_lab = ?,
		l_type = ?,
		l_desc = ?,
        l_data = ?,
        l_date = ?");
        $a = $goLog->execute(array(
            $l_lab,
            $l_type,
            $l_desc,
            $l_data,
            $l_date
        ));

        $goout = $db->prepare("UPDATE users SET
        u_status116 = :u_status116
        WHERE u_id = :u_id");
        $gooutupdate = $goout->execute(array(
            "u_status116" => "out",
            "u_id" => $id
        ));



        if ($inLab["count(*)"] == 1) {
            $l_type = 4;
            $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Labı kapattı.";
            $l_data = $id;
            $l_date = date("Y-m-d H:i:s");

            $goLog = $db->prepare("INSERT INTO logs SET
            l_lab = ?,
            l_type = ?,
            l_desc = ?,
            l_data = ?,
            l_date = ? ");
            $c = $goLog->execute(array(
                $l_lab,
                $l_type,
                $l_desc,
                $l_data,
                $l_date
            ));

            if (!$c) {
                header("Location: 404.php");
            }
        }
    }
    */

    $inLab = $db->query("SELECT * FROM users WHERE u_status='in'")->fetch(PDO::FETCH_ASSOC);
    if (!$inLab) {
        $l_type = 3;
        $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Labı açtı.";
        $l_data = $id;
        $l_date = date("Y-m-d H:i:s");

        $goLog = $db->prepare("INSERT INTO logs SET
		l_type = ?,
		l_desc = ?,
        l_data = ?,
        l_date = ?");
        $a = $goLog->execute(array(
            $l_type,
            $l_desc,
            $l_data,
            $l_date
        ));

        if (!$a) {
            header("Location: 404.php");
        }
    }
    $l_type = 1;
    $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Laba girdi.";
    $l_data = $id;
    $l_date = date("Y-m-d H:i:s");
    $goLog = $db->prepare("INSERT INTO logs SET
		l_type = ?,
		l_desc = ?,
        l_data = ?,
        l_date = ?");
    $a = $goLog->execute(array(
        $l_type,
        $l_desc,
        $l_data,
        $l_date
    ));

    $goin = $db->prepare("UPDATE users SET
    u_status = :u_status
    WHERE u_id = :u_id");
    $goinupdate = $goin->execute(array(
        "u_status" => "in",
        "u_id" => $id
    ));

    if ($a && $goinupdate) {
        header("Location: /lks");
    } else {
        header("Location: 404.php");
    }
}
