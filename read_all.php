<!-- fetch data 連接 puli_restaurant 取得資料 -->
<!-- 傳json格式給地圖 -->
<?php
    include("con_puli_db");
    @$X = $_GET['x'];
    @$Y = $_GET['y'];
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM puli_restaurant WHERE Restaurant_x = '$X' and Restaurant_y = '$Y'";
    $result = $link->query($sql);
    
    if ($result -> num_rows > 0) {
        // 輸出數據
        while($row = $result->fetch_assoc()) {
            $restaurant = 
            array(" Restaurant_ID: " . $row["Restaurant_ID"]. 
            " Restaurant_name: " . $row["Restaurant_name"].
            " Restaurant_TEL: " . $row["Restaurant_TEL"]. 
            " Restaurant_intro: " . $row["Restaurant_intro"]. 
            " Restaurant_time: " . $row["Restaurant_time"]. 
            " Restaurant_photo: " . $row["Restaurant_photo"]. 
            " Restaurant_comment	: " . $row["Restaurant_comment"]. 
            " Restaurant_price: " . $row["Restaurant_price"]. 
            " Restaurant_address: " . $row["Restaurant_address"]. 
            " Restaurant_x: " . $row["Restaurant_x"]. 
            " Restaurant_y: " . $row["Restaurant_y"]);
        }
    } else {
        echo "0 結果";
    }
    // mysqli_query($link, "SET sNAMES 'utf8'");  //設定資料庫編碼 utf8

?>