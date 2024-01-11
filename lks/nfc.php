<?php

include "connect.php";

if (isset($_GET["uid"])) {
    $uid = htmlspecialchars($_GET["uid"]);

    $uidvarmi = $db->query("SELECT * FROM users WHERE u_uid = '{$uid}'")->fetch(PDO::FETCH_ASSOC);

    if ($uidvarmi) {
        if ($uidvarmi["u_status"] == "in") {
            $inLab = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);

            $l_type = 2;
            $l_desc = $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Labdan çıktı.";
            $l_data = $uidvarmi["u_id"];
            $l_nfc = 1;
            $l_date = date("Y-m-d H:i:s");
            $goLog = $db->prepare("INSERT INTO logs SET
                l_type = ?,
                l_desc = ?,
                l_data = ?,
                l_nfc = ?,
                l_date = ?");
            $a = $goLog->execute(array(
                $l_type,
                $l_desc,
                $l_data,
                $l_nfc,
                $l_date
            ));

            $goout = $db->prepare("UPDATE users SET
            u_status = :u_status
            WHERE u_id = :u_id");
            $gooutupdate = $goout->execute(array(
                "u_status" => "out",
                "u_id" => $uidvarmi["u_id"]
            ));



            if ($inLab["count(*)"] == 1) {
                $l_type = 4;
                $l_desc = $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Labı kapattı.";
                $l_data = $uidvarmi["u_id"];
                $l_nfc = 1;
                $l_date = date("Y-m-d H:i:s");

                $goLog = $db->prepare("INSERT INTO logs SET
                l_type = ?,
                l_desc = ?,
                l_data = ?,
                l_nfc = ?,
                l_date = ? ");
                $c = $goLog->execute(array(
                    $l_type,
                    $l_desc,
                    $l_data,
                    $l_nfc,
                    $l_date
                ));

                if (!$c) {
                    echo "404.3";
                    //header("Location: 404.php");
                }
            }

            if ($a && $gooutupdate) {
                echo  $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Labdan çıktı";
                //header("Location: /lks");
            } else {
                echo "404.2";
                //header("Location: 404.php");
            }
        } else if ($uidvarmi["u_status"] == "out") {

            $inLab = $db->query("SELECT * FROM users WHERE u_status= 'in'")->fetch(PDO::FETCH_ASSOC);

            if (!$inLab) {
                $l_type = 3;
                $l_desc = $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Labı açtı.";
                $l_data = $uidvarmi["u_id"];
                $l_nfc = 1;
                $l_date = date("Y-m-d H:i:s");

                $goLog = $db->prepare("INSERT INTO logs SET
                l_type = ?,
                l_desc = ?,
                l_data = ?,
                l_nfc = ?,
                l_date = ? ");
                $a = $goLog->execute(array(
                    $l_type,
                    $l_desc,
                    $l_data,
                    $l_nfc,
                    $l_date
                ));

                if (!$a) {
                    echo "404.5";
                    //header("Location: 404.php");
                }
            }
            $l_type = 1;
            $l_desc = $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Laba girdi.";
            $l_data = $uidvarmi["u_id"];
            $l_nfc = 1;
            $l_date = date("Y-m-d H:i:s");
            
            $goLog = $db->prepare("INSERT INTO logs SET
            l_type = ?,
            l_desc = ?,
            l_data = ?,
            l_nfc = ?,
            l_date = ? ");
            $a = $goLog->execute(array(
                $l_type,
                $l_desc,
                $l_data,
                $l_nfc,
                $l_date
            ));

            $goin = $db->prepare("UPDATE users SET
            u_status = :u_status
            WHERE u_id = :u_id");
            $goinupdate = $goin->execute(array(
                "u_status" => "in",
                "u_id" => $uidvarmi["u_id"]
            ));

            if ($a && $goinupdate) {
                echo  $uidvarmi["u_name"] . " " . $uidvarmi["u_surname"] . " Laba girdi";
                //header("Location: /lks");
            } else {
                echo "404.4";
                //header("Location: 404.php");
            }
        }
    } else {
        echo "NotFoundUser";
    }
} else if (isset($_POST["uid"])) {
    echo "WrongMethod";
} else {
    echo "404.1";
}
