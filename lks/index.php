<?php

include "connect.php";
header("Refresh:15; url=/lks");
$tarih = date("Y-m-d");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $inLab = $db->query("SELECT count(*) FROM users WHERE u_status = 'in'")->fetch(PDO::FETCH_ASSOC);

    if ($inLab["count(*)"]==0) {
        $labStatus = 0;
    } else {
        $labStatus = 1;
    }
    
    $kackisi = $db->query("SELECT count(*) FROM users")->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name=”robots” content=”noindex,nofollow”>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SAMET-LAB |  </title>
    <link rel="stylesheet"  type="text/css" href="reset.css" />
    <link rel="stylesheet"  type="text/css" href="style.css"  />
</head>

<body id="index" translate="no">
    <?php

    if (isset($_GET["err"]) && $_GET["err"] == "alreadyOutside") {
    ?>
    <script>
    alert("Zaten Labda Değilsin!");
    </script>
    <?php
    } else if (isset($_GET["err"]) && $_GET["err"] == "alreadyInside") {
    ?>
    <script>
    alert("Zaten Labdasın!");
    </script>
    <?php
    }

    ?>

    <div class="container">
        <div class="top">
            <span>LAB  <?php if ($labStatus) {
                            echo "Online";
                        } else {
                            echo "Offline";
                        } ?></span>
        </div>
        <div class="mid">
            <p class="p">İçeridekiler - <?php echo $inLab["count(*)"]."/".$kackisi["count(*)"];?></p>
            <hr>
            <?php
            $query = $db->query("SELECT * FROM users WHERE u_status = 'in'", PDO::FETCH_ASSOC);
            if ($query && $query->rowCount()) {
                foreach ($query as $user) {
            ?>
            <p class="inUser">
                <?php
                if(($_SESSION["rank"]=="admin" || $_SESSION["rank"]=="admin+")) {
                    if(($user["u_rank"] != "admin") || $_SESSION["id"] == 1){
                    echo "<span style=\"cursor: pointer;\" onclick='window.location = \"https://sametlab.com/lks/zorla.php?zorla=". $user["u_id"]."\"'>X </span>";
                    }else{
                        echo "<span>  </span>";
                    }
                }
                echo $user["u_name"] . " " . $user["u_surname"]; 
                
                ?>  
            </p>
            <?php
                }
            } else {
                ?>
            <span class="noOne">Labda Kimse Yok</span>
            <?php
            }
            ?>
        </div>
        <div class="logout" style="text-align: center;">
            <a style="color: white; font-size: 24px; cursor: pointer;" href="logout.php">Logout&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </div>
        <?php

        if (isset($_SESSION["rank"]) && $_SESSION["rank"] == "admin") {
        ?>

        <div class="logs">
            <div class="top">
                <span id="allBtn" onclick="logChange(1)">Bugün</span>
                <span id="inOutBtn" onclick="logChange(2)">Giriş-Çıkış</span>
                <span id="openCloseBtn" onclick="logChange(3)">Açılış-Kapanış</span>
                <span onclick="window.location= 'all.php';">Hepsi</span>
            </div>
            <br>
            <div class="bot">
                <div id="all">
                    <?php
                        $all = $db->query("SELECT * FROM logs WHERE (l_date LIKE '{$tarih}%') AND l_lab = '114' ORDER BY l_id DESC", PDO::FETCH_ASSOC);
                        if ($all && $all->rowCount()) {
                            $a1 = 1;
                        ?>
                    <table class="tablo">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Desc</th>
                                <th>Data</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    foreach ($all as $log) {
                                    ?>


                            <tr class="<?php if ($a1 % 2 == 0) {
                                                        echo 'active';
                                                    } ?>">
                                <td><span class="id"><?php echo $log["l_id"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_type"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_desc"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_data"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_date"]; ?></span></td>
                            </tr>
                            <?php
                                        $a1++;
                                    }
                                    ?>

                        </tbody>
                    </table>
                    <?php
                        } else {
                        ?>
                    <span class="noOne">Herhangi Bir Log Kaydı Bulunamadı</span>
                    <?php
                        }
                        ?>
                </div>
                <div id="in-out" style="display: none;">
                    <?php
                        $all = $db->query("SELECT * FROM logs WHERE l_date LIKE '{$tarih}%' AND (l_type = '1' OR l_type = '2') AND l_lab = '114' ORDER BY l_id DESC", PDO::FETCH_ASSOC);
                        if ($all && $all->rowCount()) {
                            $a2 = 1;
                        ?>
                    <table class="tablo">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Desc</th>
                                <th>Data</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    foreach ($all as $log) {
                                    ?>


                            <tr class="<?php if ($a2 % 2 == 0) {
                                                        echo 'active';
                                                    } ?>">
                                <td><span class="id"><?php echo $log["l_id"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_type"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_desc"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_data"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_date"]; ?></span></td>
                            </tr>
                            <?php
                                        $a2++;
                                    }
                                    ?>

                        </tbody>
                    </table>
                    <?php
                        } else {
                        ?>
                    <span class="noOne">Herhangi Bir Log Kaydı Bulunamadı</span>
                    <?php
                        }
                        ?>
                </div>
                <div id="open-close" style="display: none;">
                    <?php
                        $all = $db->query("SELECT * FROM logs WHERE (l_date LIKE '{$tarih}%') AND (l_type = '3' OR l_type = '4') AND l_lab = '114' ORDER BY l_id DESC", PDO::FETCH_ASSOC);
                        if ($all && $all->rowCount()) {
                            $a3 = 1;
                        ?>
                    <table class="tablo">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Desc</th>
                                <th>Data</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    foreach ($all as $log) {
                                    ?>


                            <tr class="<?php if ($a3 % 2 == 0) {
                                                        echo 'active';
                                                    } ?>">
                                <td><span class="id"><?php echo $log["l_id"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_type"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_desc"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_data"]; ?></span></td>
                                <td><span class="id"><?php echo $log["l_date"]; ?></span></td>
                            </tr>
                            <?php
                                        $a3++;
                                    }
                                    ?>

                        </tbody>
                    </table>
                    <?php
                        } else {
                        ?>
                    <span class="noOne">Herhangi Bir Log Kaydı Bulunamadı</span>
                    <?php
                        }
                        ?>
                </div>
            </div>
        </div>
        <?php
        }

        ?>
    </div>
    <br>
    <br>
    <br>
    <br>

<?php
if(isset($_SESSION['id']) && $_SESSION['id'] != 49){?>
    <div class="fixedBot">
        <div class="container">
            <span class="goIn"><a href="goin.php" style="width: 100%; height: 100%; line-height: 50px;">Giriş</a></span>
            <span class="goOut"><a href="goout.php" style="width: 100%; height: 100%; line-height: 50px;">Çıkış</a></span>
        </div>
    </div>
    <?php
}

?>

    


    <script>
    function logChange($type) {
        switch ($type) {
            case 1:
                document.getElementById("all").style.display = "block";
                document.getElementById("in-out").style.display = "none";
                document.getElementById("open-close").style.display = "none";
                break;
            case 2:
                document.getElementById("all").style.display = "none";
                document.getElementById("in-out").style.display = "block";
                document.getElementById("open-close").style.display = "none";
                break;
            case 3:
                document.getElementById("all").style.display = "none";
                document.getElementById("in-out").style.display = "none";
                document.getElementById("open-close").style.display = "block";
                break;

            default:
                return;
                break;
        }
    }
    </script>

</body>

</html>