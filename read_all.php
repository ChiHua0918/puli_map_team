<?php
    // fetch data 連接 puli_restaurant 取得資料
    // 傳json格式給地圖
    
    include("connect.php");
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM puli_restaurant";
    $result = $link->query($sql);
    $arr_data = [];
    if ($result -> num_rows > 0) {
        // 輸出數據
        while($row = $result->fetch_assoc()) {
            $restaurant = 
            array("RestaurantID" => $row["Restaurant_ID"], 
            "RestaurantName" => $row["Restaurant_name"],
            "RestaurantTEL" => $row["Restaurant_TEL"], 
            "RestaurantIntro" => $row["Restaurant_intro"], 
            "RestaurantTime" => $row["Restaurant_time"], 
            "RestaurantPhoto" => $row["Restaurant_photo"], 
            "RestaurantComment" => $row["Restaurant_comment"], 
            "RestaurantPrice" => $row["Restaurant_price"], 
            "RestaurantAddress" => $row["Restaurant_address"], 
            "RestaurantX" => $row["Restaurant_x"], 
            "RestaurantY" => $row["Restaurant_y"],
            "wordpressLink" => $row['wordpress_link']);
            array_push($arr_data,$restaurant);
        }
	echo json_encode($arr_data,JSON_NUMERIC_CHECK);
    } else {
        echo "0 結果";
    }

?>
