<?php
include "../connect.php";

$result = array(
    "status" => "error",
    "message" => "Erişiminiz engellendi."
);

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data["key"]) && $data["key"] == "sametisthebestwebci") {

    $result = array(
        "status" => "error",
        "message" => "Bir hata oluştu."
    );

    $name = $data["name"];
    $surname = $data["surname"];
    $no = $data["no"];
    $uid = $data["uid"];
    $nick = $data["nick"];
    $pass = $data["pass"];
    $rank = "uye";

    // check if datas empty
    if (empty($name) || empty($surname) || empty($no) || empty($uid) || empty($nick) || empty($pass)) {
        $result = array(
            "status" => "error",
            "message" => "Lütfen tüm alanları doldurun."
        );
    } else {
        $varmi1 = $db->query("SELECT * FROM users WHERE u_no = '{$no}'")->fetch(PDO::FETCH_ASSOC);

        if ($varmi1) {
            $result = array(
                "status" => "error",
                "message" => "Bu numara ile kayıtlı bir kullanıcı zaten var."
            );
        } else {
            // check for nick
            $varmi2 = $db->query("SELECT * FROM users WHERE u_nick = '{$nick}'")->fetch(PDO::FETCH_ASSOC);
            if ($varmi2) {
                $result = array(
                    "status" => "error",
                    "message" => "Bu kullanıcı adı ile kayıtlı bir kullanıcı zaten var."
                );
            } else {
                // cehck for uid
                $varmi3 = $db->query("SELECT * FROM users WHERE u_uid = '{$uid}'")->fetch(PDO::FETCH_ASSOC);
                if ($varmi3) {
                    $result = array(
                        "status" => "error",
                        "message" => "Bu UID ile kayıtlı bir kullanıcı zaten var."
                    );
                } else {
                    $olkayit = $db->prepare("INSERT INTO users SET
                u_name = ?,
                u_surname = ?,
                u_no = ?,
                u_uid = ?,
                u_nick = ?,
                u_pass = ?,
                u_rank = ?");
                    $a = $olkayit->execute(array(
                        $name,
                        $surname,
                        $no,
                        $uid,
                        $nick,
                        $pass,
                        $rank
                    ));

                    if ($a) {
                        $result = array(
                            "status" => "success",
                            "message" => "Kayıt başarılı."
                        );
                    } else {
                        $result = array(
                            "status" => "error",
                            "message" => "Kayıt başarısız."
                        );
                    }
                }
            }
        }
    }
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
