<?php
include "connect.php";


if (isset($_SESSION["id"])) {
    header("Location: /lks/");
} else {
    if (isset($_POST["ailogin"])) {
        $nick = $_POST["nick"];
        $pass = md5($_POST["pass"]);

        $varmi1 = $db->query("SELECT * FROM users WHERE u_nick = '{$nick}'")->fetch(PDO::FETCH_ASSOC);

        if (!isset($varmi1)) {
            header("Location: login.php?err=userNotFound");
        } else {
            if ($varmi1["u_rank"] == "banned") {
                header("Location: login.php?err=bannedUser");
            } else {
                if ($varmi1["u_pass"] != $pass) {
                    header("Location: login.php?err=wrongPass");
                } else {
                    $_SESSION["id"] = $varmi1["u_id"];
                    $_SESSION["rank"] = $varmi1["u_rank"];
                    header("Location: /lks");
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name=”robots” content=”noindex,nofollow”>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Giriş Yap | SAMET-LAB-LAB</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="manifest" href="manifest.json?v=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="SAMET-LABlab.com/lks">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon" sizes="128x128" href="/lks/pwa/img/128x128.png">
    <link rel="apple-touch-icon-precomposed" sizes="128x128" href="/lks/pwa/img/128x128.png">
    <link rel="icon" sizes="192x192" href="/lks/pwa/img/192x192.png">
    <link rel="icon" sizes="128x128" href="/lks/pwa/img/128x128.png">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/lks/sw.js?v=3');
            });
        }
    </script>
</head>

<body translate="no">
    <?php

    if (isset($_GET["err"]) && $_GET["err"] == "userNotFound") {
    ?>
        <script>
            alert("Üye Bulunamadı!!");
        </script>
    <?php
    } else if (isset($_GET["err"]) && $_GET["err"] == "bannedUser") {
    ?>
        <script>
            alert("Maalesef sisteme giriş yapamazsınız.");
        </script>
    <?php
    }

    ?>
    <div class="login-main-div">
        <div class="logo">
            <img src="img/logo3.png" alt="">
        </div>
        <div class="labStatus form" style="text-align: center; width: 250px; padding: 15px 25px; margin-bottom: 5px; border-radius: 20px 20px 0 0;">
            <span style="color: white; font-size: 24px; padding-bottom: 5px;">
                <?php
                $inLabs = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);

                if (!$inLabs["count(*)"]) {
                    echo "LAB  Kapalı";
                } else {
                    echo "LAB  Açık";
                }
                ?>
            </span>
        </div>
        <div class="form" style="border-radius: 0 0 20px 20px;">
            <form action="" method="post" autocomplete="on">
                <input type="text" name="nick" placeholder="Kullanıcı Adı" autocomplete="username">
                <input type="password" name="pass" placeholder="Şifre" autocomplete="current-password">
                <input type="submit" name="ailogin" value="Giriş Yap">
            </form>
        </div>
    </div>
    <span style="position: absolute; bottom:0; right: 10px; color: rgba(255, 255, 255, .5);">Created
        by
        Sametnbyl Soft</span>
</body>

</html>