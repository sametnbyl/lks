<?php

include "connect.php";
?>

<html>

<head>
    <title>SAMET-LAB | Logs</title>

    <style>
        #veri {
            width: 100%;
            text-align: center;
        }

        #veri thead {
            background-color: black;
            color: white;
            padding: 10px 0px;
        }

        #veri tr{
            height: 25px;
            padding: 10px;
        }

        .gri {
            background-color: gray;
            color: white;
        }
    </style>
</head>

<body>

    <table id="veri">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lab</th>
                <th>Type</th>
                <th>Desc</th>
                <th>Data</th>
                <th>NFC</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION["rank"]) && $_SESSION["rank"] == "admin") {
                $x = 0;
                $all = $db->query("SELECT * FROM logs WHERE l_lab = '114' ORDER BY l_id DESC", PDO::FETCH_ASSOC);
                foreach ($all as $log) {

            ?>
                    <tr <?php if ($x%2 == 0) echo 'class="gri"';?>>
                        <td><?php echo $log["l_id"]; ?></td>
                        <td><?php echo $log["l_lab"]; ?></td>
                        <td><?php echo $log["l_type"]; ?></td>
                        <td><?php echo $log["l_desc"]; ?></td>
                        <td><?php echo $log["l_data"]; ?></td>
                        <td><?php echo $log["l_nfc"]; ?></td>
                        <td><?php echo $log["l_date"]; ?></td>
                    </tr>

            <?php
                    $x++;
                }
            } else {
                header("Location: /lab");
            }
            ?>
        </tbody>
    </table>
</body>

</html>