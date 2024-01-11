<?php

try {
        $db = new PDO("mysql:host=localhost;dbname=samet_lab;charset=utf8mb4", "samet_lab", "192837lab.");
    } catch (PDOException $e) {
        print $e->getMessage();
    }
/*
if(isset($_POST["fromApp"]) && $_POST["fromApp"]=="vallahbenim"){
    if (isset($_POST["isOnline"])) {
        $inLab = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);
        echo $inLab["count(*)"];
        $obje->data = $inLab["count(*)"];
        $objem = json_encode($obje);
        echo $objem;
    }
}else if(isset($_GET["deneme"])){
    echo "denendin";
}else{
    echo "slm";
}*/

// kendi domainim dısındaki scriptlere izin veriyorum
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

if (isset($_GET["fromApp"]) && $_GET["fromApp"] == "vallahbenim") {
    if (isset($_GET["inLabCount"])) {
        $inLab = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);
        $total = $db->query("SELECT count(*) FROM users WHERE u_status!= 'banned'")->fetch(PDO::FETCH_ASSOC);

        $count = $inLab["count(*)"];
        $total = $total["count(*)"];

        $res[] = array("count" => $count, "total" => $total);
        echo json_encode($res);
    } else if (isset($_GET["loginTry"])) {
        $nick = htmlspecialchars($_GET["nick"]);
        $pass = htmlspecialchars(md5($_GET["pass"]));

        $varmi1 = $db->query("SELECT * FROM users WHERE u_nick = '{$nick}'")->fetch(PDO::FETCH_ASSOC);

        if (!isset($varmi1)) {
            $res[] = array("err" => "Kullanıcı bulunamadı!");
            echo json_encode($res);
        } else {
            if ($varmi1["u_rank"] == "banned") {
                $res[] = array("err" => "Kullanıcı giriş yapamaz!");
                echo json_encode($res);
            } else {
                if ($varmi1["u_pass"] != $pass) {
                    $res[] = array("err" => "Kullanıcı adı veya şifre hatalı!");
                    echo json_encode($res);
                } else {
                    $res[] = array("u_id" => $varmi1["u_id"], "u_name" => $varmi1["u_name"], "u_surname" => $varmi1["u_surname"], "u_no" => $varmi1["u_no"], "u_nick" => $varmi1["u_nick"], "u_rank" => $varmi1["u_rank"]);
                    echo json_encode($res);
                }
            }
        }
    }else if (isset($_GET["getInside"])){
        $res[]=null;
        $query = $db->query("SELECT * FROM users WHERE u_status= 'in'", PDO::FETCH_ASSOC);
        if ($query && $query->rowCount()) {
            foreach ($query as $user) {
                $u = array("u_id" => $user["u_id"], "u_name" => $user["u_name"], "u_surname" => $user["u_surname"], "u_no" => $user["u_no"], "u_nick" => $user["u_nick"], "u_rank" => $user["u_rank"]);
                array_push($res, $u);
            }
        }
        array_shift($res);
        echo json_encode($res);
    }
}
