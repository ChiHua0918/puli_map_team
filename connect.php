<?php
    // fetch data 連接資料庫 取得資料
    $link = mysqli_connect("localhost","root","","wordpress"); 
    // db_host, db_username, db_password, db_name
    if ($link == false) {
        die("連接失敗: " .mysqli_connect_error());
    }
?>