<?php
include "connect.php";


if (isset($_SESSION["rank"]) && $_SESSION["rank"] == "admin") {
    if (isset($_POST["kayit"])) {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $no = $_POST["no"];
        $nick = $_POST["nick"];
        $pass = md5($_POST["pass"]);
        
        
        $varmi1 = $db->query("SELECT * FROM users WHERE u_no = '{$no}'")->fetch(PDO::FETCH_ASSOC);

        if($varmi1){
                header("Location: register.php?err=NickAlreadyTaken");
        }else{
            $olkayit = $db->prepare("INSERT INTO users SET
    		u_name = ?,
    		u_surname = ?,
            u_no = ?,
            u_nick = ?,
            u_pass = ?");
            $a = $olkayit->execute(array(
                $name,
                $surname,
                $no,
                $nick,
                $pass
            ));
            
            if($a){
                header("Location: register.php?ok=");
            }else{
                header("Location: register.php?nope=");
            }
        }
    }
} else {
    header("Location: /lks");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Kaydol | SAMET-LAB</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php

    if (isset($_GET["err"]) && $_GET["err"] == "NickAlreadyTaken") {
    ?>
    <script>
    alert("Zaten kayıtlı!");
    </script>
    <?php
    } else if (isset($_GET["ok"])) {
    ?>
    <script>
    alert("Kayıt Tamamlandı!");
    </script>
    <?php
    } else if (isset($_GET["nope"])) {
    ?>
    <script>
    alert("Bi hata oldu!");
    </script>
    <?php
    }

    ?>
    <div class="maindiv">
        <img src="img/logo.jpg" alt="">
        <form id="regform" action="" method="post" autocomplete="off">
            <input type="text" name="name" placeholder="ad" required>
            <input type="text" name="surname" placeholder="soyad" required>
            <input type="text" name="no" placeholder="okul no" required>
            <input type="text" name="nick" placeholder="kullanıcı adı" required>
            <input type="password" name="pass" placeholder="şifre" required>
            <input type="submit" name="kayit" value="Kaydol">
        </form>

    </div>

</body>

</html>