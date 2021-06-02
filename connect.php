<?php
    // fetch data 連接資料庫 取得資料
    $link = mysqli_connect("localhost","foodmap","foodmap@puli#ncnu","wordpress"); 
    // db_host, db_username, db_password, db_name
    if ($link == false) {
        die("連接失敗: " .mysqli_connect_error());
    }
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM `wp_users`";

    // 以下程式是將DB中的資料印出來
    // $result 從DB中取出結果集
    $result = $link->query($sql);
    $row = mysqli_fetch_assoc($result);
    
    mysqli_query($link, "SET NAMES 'utf8'");  //設定資料庫編碼 utf8
?>