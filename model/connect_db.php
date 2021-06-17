<?php
    // fetch data 連接資料庫 取得資料
    //  資料夾位置
    $db_server = "localhost";
    //  資料庫管理者帳號
    $db_user = "foodmap";
    //  資料庫管理者密碼
    $db_password = "foodmap@puli#ncnu";
    //  資料庫名稱
    $db_name = "foodmapadmin";
    $link = mysqli_connect($db_server,$db_user,$db_password,$db_name); 
    if ($link === false) {
        die("連接失敗: ".mysqli_connect_error());
    }    
    mysqli_query($link, "SET NAMES utf8");
?>
