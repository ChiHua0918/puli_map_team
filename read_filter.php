<?php 
    // db_host, db_username, db_password, db_name
    include("connect.php");
    //$link = mysqli_connect("localhost","root","james","wordpress"); 

    // 使用者在下拉式選單選的條件
    // 時間 
    $time = $_POST['time'];
    // 類別
    $type = $_POST['type'];
    // 價錢
    $price = $_POST['price'];
    // 使用者目前位置
    $userLocation = $_POST['userLocation'];
    // 距離範圍
    $dist = $_POST['dist'];

    // 判斷今天星期幾
    date_default_timezone_set("Asia/Taipei");
    $todayDate = date("w");

    // echo $todayDate;

    //echo "time:" . $time . " type:" . $type . " price:" . $price . " dist:" . $dist . " userLocation:" . $userLocation;

    // 篩選動作 (依 使用者偏好的選項 進行篩選)
    // 將 puli_restaurant, puli_rest_time 資料表做連接    
    // JOIN 結合多個資料表，組成一個暫時性的資料表 供查詢
    $f_sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
    puli_restaurant.Restaurant_intro, puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
    puli_restaurant.Restaurant_comment, puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
    puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y 
    FROM puli_restaurant 
    LEFT JOIN puli_rest_time on puli_restaurant.Restaurant_ID = puli_rest_time.Restaurant_ID 
    LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID 
    WHERE puli_rest_time.Day_ID = '".$todayDate."'  ";
    // <---- delete ---->
    // WHERE puli_rest_time.Day_ID = '".$todayDate."' 
    // <--- --->

    // 時間
    if ($time != ""){
        // 時間 (使用者選的時間)
        // 14:00 => "14:00"
        $time = htmlspecialchars($time);
        // $f_sql = $f_sql."AND puli_rest_time.Day_ID = '".$today_date."' AND puli_rest_time.open_time <= '".$time."' AND puli_rest_time.end_time >= '".$time."' ";
        $f_sql = $f_sql." AND puli_rest_time.open_time <= '".$time."' 
        AND puli_rest_time.end_time >= '".$time."' ";
        }
    // 類別
    if ($type!= ""){
        $f_sql = $f_sql."AND Category_name = '".$type."' ";
    }
    // 價位
    if ($price != "") {
        $min_max = explode("~", $price);
        // echo gettype($min_max[0]);
        // print_r($min_max);
        // 換成int
        
        if ($min_max[1] == ""){
            $min_max[1] = 100000;
        }
        else if ($min_max[0] == ""){
            $min_max[0] = 0;
        }
        // 因為價格為一個平均價，所以篩選會取大一些 EX:網頁篩選條件00~150 => 實際篩選70~180
        $min = (int)$min_max[0]-30;
        $max = (int)$min_max[1]+30;

        $f_sql = $f_sql . "AND puli_restaurant.Restaurant_price >= $min AND puli_restaurant.Restaurant_price <= $max";
    }

    // $result 從DB中取出結果集
    $result = $link->query($f_sql);

    // 將篩選完的資料放入arr_fl_data
    $arr_fl_data = [];
    if ($result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $restaurant = 
            array("RestaurantID" => $row["Restaurant_ID"], 
                "RestaurantAddress" => $row["Restaurant_address"]);

            array_push($arr_fl_data,$restaurant);
        }
        // 先做時間、價錢、類別的篩選
        // 如果有選距離篩選，再把前面篩選之結果 做距離的篩選
        if ($dist != NULL && count($arr_fl_data) != 0){
            $dist = explode(" ", $dist);
            $dist = $dist[0];
            for ($i = 0; $i < count($arr_fl_data); $i++){
                //PHP代碼以檢索JSON數據 
                $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($userLocation).'&destinations='.urlencode($arr_fl_data[$i]['RestaurantAddress']).'&key=AIzaSyAE86ozbw5PYKeYzhTaZ71buMjLMozzc_U');
                // JSON解碼，數據作為變量的Array形式獲得
                $distance_arr = json_decode($distance_data);

                // print_r($arr_fl_data[$i]['Restaurant_ID']);
                $distance = $distance_arr -> rows[0] -> elements[0] -> distance -> text;
                $distance = explode(" ", $distance);
                // 公尺單位改公里
                if ($distance[1] == "m"){
                    $distance[0] = $distance[0]/1000;
                }
                // 取數字
                $distance = $distance[0];
                $drive_dis = floatval($distance); 
                // echo $drive_dis;
                // 範圍外
                if ($drive_dis > $dist){
                    // echo $arr_fl_data[$i]['RestaurantID'];
                    array_splice($arr_fl_data,$i,1);
                }
            }
        }
    }
    //print_r($arr_fl_data);
    // 轉json
    $final = json_encode($arr_fl_data,JSON_NUMERIC_CHECK);
    echo $final;

?>