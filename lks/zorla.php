<?php

include "connect.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["rank"]!="admin" && $_SESSION["rank"]!="admin+") {
    header("Location: login.php");
} 

if(isset($_GET['zorla'])){
    $id = $_GET['zorla'];
    $user = $db->query("SELECT * FROM users WHERE u_id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || $user["u_status"] == "out") {
        header("Location: /lks");
    } else {
        $pp = $user["u_pp"] + 1;
        
        $getpp = $db->prepare("UPDATE users SET
        u_pp = :u_pp
        WHERE u_id = :u_id");
        $getpp2 = $getpp->execute(array(
            "u_pp" => $pp,
            "u_id" => $id
        ));
        
        $inLab = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);
    
        $l_type = 5;
        $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Labdan çıkarıldı.";
        $l_data = $id.",".$_SESSION["id"];
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
    
        $goout = $db->prepare("UPDATE users SET
        u_status = :u_status
        WHERE u_id = :u_id");
        $gooutupdate = $goout->execute(array(
            "u_status" => "out",
            "u_id" => $id
        ));
    
    
    
        if ($inLab["count(*)"] == 1) {
            $l_type = 6;
            $l_desc = $user["u_name"] . " " . $user["u_surname"] . " Labı kapattı (z).";
            $l_data = $id.",".$_SESSION["id"];
            $l_date = date("Y-m-d H:i:s"); 
    
            $goLog = $db->prepare("INSERT INTO logs SET
    		l_type = ?,
    		l_desc = ?,
            l_data = ?,
            l_date = ? ");
            $c = $goLog->execute(array(
                $l_type,
                $l_desc,
                $l_data,
                $l_date
            ));
    
            if (!$c) {
                header("Location: 404.php");
            }
        }
    
        if ($a && $gooutupdate && $getpp2) {
            header("Location: /lks");
        } else {
            header("Location: 404.php");
        }
    }


}else{
    header("Location: /lks");
}

?>