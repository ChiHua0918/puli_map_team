<!-- fetch data 連接資料庫 取得資料 -->
<?php
    // db_host, db_username, db_password, db_name
    $link = mysqli_connect("localhost","root","","wordpress"); 
    if ($link == false) {
        die("連接失敗: " .mysqli_connect_error());
    }
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM `puli_manager`";

    // 以下程式是將DB中的資料印出來
    // $result 從DB中取出結果集
    $result = $link->query($sql);
    $row = mysqli_fetch_assoc($result);
    // if ($result->num_rows >= 0) {
    //     // 輸出數據
    //     // echo "id: "."     "."Name: "."      "."username: ". "<br>";
    //     while($row = $result->fetch_assoc()) {
    //         // id name username password
    //         echo " id: " . $row["ID"]. 
    //         " 帳號: " . $row["user_login"].
    //         " 密碼: " . $row["user_pass"]. 
    //         " 姓名: " . $row["user_nicename"]. 
    //         " 信箱: " . $row["user_email"]. 
    //         " userUrl: " . $row["user_url"]. 
    //         " userRegisterd: " . $row["user_registered"]. 
    //         " userActivationKey: " . $row["user_activation_key"]. 
    //         " userStatus: " . $row["user_status"]. 
    //         " displayName: " . $row["display_name"]. "<br>";
    //     }
    // } else {
    //     echo "0 結果";
    // }
    mysqli_query($link, "SET NAMES 'utf8'");  //設定資料庫編碼 utf8

// $link->close();
?>

