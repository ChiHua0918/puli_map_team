<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
include("con_puli_db.php");
// 抓前端的資料
@$user_login = $_POST['user_login'];
@$user_pass = $_POST['user_pass'];

// 搜尋資料庫資料
$sql = "SELECT * FROM puli_manager Where user_login = '$user_login'";

$result = mysqli_query($link, $sql);
// $rows = mysqli_num_rows($result);

// 登入成功
// 確認是否為MySQL資料庫裡是否有這個會員
while ($row = mysqli_fetch_assoc($result)) {
    if ($user_login != null && $user_pass != null && $user_login == $row['user_login'] && $user_pass == $row['user_pass']) {
        // SESSION:使用者使用網頁時暫存的東西
        // 我們先將暫帳號暫存，方便後面核對身分
        $_SESSION['user_login'] = $user_login;
        $sql_status = "UPDATE `puli_manager` SET `user_status`= 1 WHERE user_login = '$user_login'";
        $result_status = mysqli_query($link, $sql_status);
        echo '登入成功!';
        echo $_SESSION['user_login'];
    } else {
        echo $row["user_login"] . $row["user_pass"];
        echo '登入失敗!';
    }
}
?>