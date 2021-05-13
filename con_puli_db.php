<!-- fetch data 連接資料庫 取得資料 -->
<?php
    //  資料夾位置
    $db_server = "localhost";
    //  資料庫管理者帳號
    $db_user = "root";
    //  資料庫管理者密碼
    $db_password = "";
    //  資料庫名稱
    $db_name = "wordpress";
    $link = mysqli_connect($db_server,$db_user,$db_password,$db_name); 
    if ($link === false) {
        die("連接失敗: ".mysqli_connect_error());
    }
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM `puli_manager`";

    // 以下程式是將DB中的資料印出來
    // $result 從DB中取出結果集
    $result = $link->query($sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_query($link, "SET NAMES 'utf8'");  //設定資料庫編碼 utf8
    
?>