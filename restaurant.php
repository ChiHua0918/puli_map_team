<?php
    require_once("connect_db.php");

    function  get_all_restaurant_info() {
        // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
        global $link;
        $sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
        puli_restaurant.Restaurant_intro, puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
        puli_restaurant.Restaurant_comment, puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
        puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y, puli_restaurant.wordpress_link,puli_recommend.Category_name
        FROM puli_restaurant
        LEFT JOIN puli_rest_time on puli_restaurant.Restaurant_ID = puli_rest_time.Restaurant_ID 
        LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID";
        $result = $link->query($sql);
        $arr_data = [];
        if ($result -> num_rows > 0) {
            // 輸出數據
            while($row = $result->fetch_assoc()) {
                $restaurant = array(
                    "Restaurant_ID" => $row["Restaurant_ID"], 
                    "Restaurant_name" => $row["Restaurant_name"],
                    "Restaurant_TEL" => $row["Restaurant_TEL"], 
                    "Restaurant_intro" => $row["Restaurant_intro"], 
                    "Restaurant_time" => $row["Restaurant_time"], 
                    "Restaurant_photo" => $row["Restaurant_photo"], 
                    "Restaurant_comment" => $row["Restaurant_comment"], 
                    "Restaurant_price" => $row["Restaurant_price"], 
                    "Restaurant_address" => $row["Restaurant_address"], 
                    "Restaurant_x" => $row["Restaurant_x"], 
                    "Restaurant_y" => $row["Restaurant_y"],
                    "wordpress_link" => $row["wordpress_link"],
                    "CategoryName" => $row["Category_name"]
                );
                array_push($arr_data, $restaurant);
            }
        }
        return $arr_data;
    }

    function get_restaurant_info($todayDate, $time, $type, $minPrice, $maxPrice){
        global $link;
    //     // 篩選動作 (依 使用者偏好的選項 進行篩選)
    //     // 將 puli_restaurant, puli_rest_time 資料表做連接    
    //     // JOIN 結合多個資料表，組成一個暫時性的資料表 供查詢
        $f_sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
        puli_restaurant.Restaurant_intro, puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
        puli_restaurant.Restaurant_comment, puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
        puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y , puli_restaurant.wordpress_link
        FROM puli_restaurant 
        LEFT JOIN puli_rest_time on puli_restaurant.Restaurant_ID = puli_rest_time.Restaurant_ID 
        LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID 
        WHERE puli_rest_time.Day_ID = '".$todayDate."' ";

        // 時間
        if ($time != ""){
            // 時間 (使用者選的時間)
            // 14:00 => "14:00"
            $time = htmlspecialchars($_POST["time"]);
            // $f_sql = $f_sql."AND puli_rest_time.Day_ID = '".$today_date."' AND puli_rest_time.open_time <= '".$time."' AND puli_rest_time.end_time >= '".$time."' ";
            $f_sql = $f_sql." AND puli_rest_time.open_time <= '".$time."' 
            AND puli_rest_time.end_time >= '".$time."' ";
        }
        // 類別
        if ($type!=null){
            $f_sql = $f_sql."AND Category_name = '".$type."' ";
        }
        // 價位
        if ($maxPrice != NULL && $minPrice != NULL) {
            $f_sql = $f_sql . "AND restaurant_price >= '" . $minPrice . "' 
            AND restaurant_price <= '" . $maxPrice . "'";
        }

        // $result 從DB中取出結果集
        $result = $link->query($f_sql);

        // 將篩選完的資料放入arr_fl_data
        $arr_fl_data = [];
        $final_data = [];
        if ($result -> num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $restaurant = array
                (
                    "Restaurant_ID" => $row["Restaurant_ID"], 
                    "Restaurant_name" => $row["Restaurant_name"],
                    "Restaurant_TEL" => $row["Restaurant_TEL"], 
                    "Restaurant_intro" => $row["Restaurant_intro"], 
                    "Restaurant_time" => $row["Restaurant_time"], 
                    "Restaurant_photo" => $row["Restaurant_photo"], 
                    "Restaurant_comment" => $row["Restaurant_comment"], 
                    "Restaurant_price" => $row["Restaurant_price"], 
                    "Restaurant_address" => $row["Restaurant_address"], 
                    "Restaurant_x" => $row["Restaurant_x"], 
                    "Restaurant_y" => $row["Restaurant_y"],
                    "wordpress_link" => $row["wordpress_link"],
                    "CategoryName" => $row["Category_name"]
                );
                array_push($arr_fl_data, $restaurant);
            }

            // 先做時間、價錢、類別的篩選
            // 如果有選距離篩選，再把前面篩選之結果 做距離的篩選
            if ($dist != NULL && count($arr_fl_data) != NULL){
                for ($i = 0; $i < count($arr_fl_data); $i++){
                    //PHP代碼以檢索JSON數據 
                    $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($user_location).'&destinations='.urlencode($arr_fl_data[$i]['RestaurantAddress']).'&key=AIzaSyAE86ozbw5PYKeYzhTaZ71buMjLMozzc_U');
                    // JSON解碼，數據作為變量的Array形式獲得
                    $distance_arr = json_decode($distance_data);

                    // print_r($arr_fl_data[$i]['Restaurant_ID']);
                    $distance = $distance_arr -> rows[0] -> elements[0] -> distance -> text;
                    $drive_dis = floatval($distance); 
                    // 範圍內
                    if ($drive_dis <= $dist){
                        array_push($final_data, $arr_fl_data[i]);
                    }
                    // // 範圍外
                    // else{
                    //     echo "fail";
                    // }
                }
            }
        } 
        return $final_data;
    }
?>