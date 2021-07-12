<?php
    // fetch data 連接 puli_restaurant 取得資料
    // 傳json格式給地圖
    
    include("connect.php");
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
    puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
    puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
    puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y, puli_restaurant.wordpress_link,puli_recommend.Category_name
    FROM puli_restaurant
    LEFT JOIN puli_rest_time on puli_restaurant.Restaurant_ID = puli_rest_time.Restaurant_ID 
    LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID ";
    $result = $link->query($sql);
    $arr_data = [];
    $addCategory = "";
    $check = 0;
    if ($result -> num_rows > 0) {
        // 輸出數據
        while($row = $result->fetch_assoc()) {
            $restaurant = 
            array("RestaurantID" => $row["Restaurant_ID"], 
            "RestaurantName" => $row["Restaurant_name"],
            "RestaurantTEL" => $row["Restaurant_TEL"], 
            "RestaurantTime" => $row["Restaurant_time"], 
            "RestaurantPhoto" => $row["Restaurant_photo"], 
            "RestaurantPrice" => $row["Restaurant_price"], 
            "RestaurantAddress" => $row["Restaurant_address"], 
            "RestaurantX" => $row["Restaurant_x"], 
            "RestaurantY" => $row["Restaurant_y"],
            "wordpressLink" => $row['wordpress_link'],
            "CategoryName" => $row['Category_name']
            );
            if ($check == $row["Restaurant_ID"]){
                $addCategory .= $row['Category_name'];
                // print_r(count($arr_data));
                $arr_data[count($arr_data)-1]['CategoryName'] = $addCategory;
            }
            else{
                array_push($arr_data,$restaurant);
                $addCategory = $row['Category_name']; //紀錄目前餐廳ID類別
            }
            // 用來檢查餐廳ID是不是同一個  目的:讓一家餐廳的多類別顯示在同一行
            $check = $row["Restaurant_ID"];
        }
    // for ($i = 0; $i < count($arr_data); $i++){
    //     print_r($arr_data[$i]);
    //     echo "<br/><br/>";
    // }

    echo json_encode($arr_data);
    // json_encode($arr_data,JSON_NUMERIC_CHECK);
    } else {
        echo "0 結果";
    }

?>
