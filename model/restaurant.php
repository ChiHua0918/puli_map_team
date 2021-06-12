<?php
    require_once("connect_db.php");

    function get_restaurant_photoUrl_by_id($id){
        global $link;
        $sql = "SELECT Restaurant_photo FROM puli_restaurant WHERE Restaurant_ID='$id'";
        $result = $link->query($sql);
        if ($result -> num_rows > 0) {
            $row = $result->fetch_row();
            return $row[0];
        }else{
            return null;
        }
    }

    function  get_all_restaurant_info() {
        // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
        global $link;
        $sql = "SELECT * FROM puli_restaurant";
        $result = $link->query($sql);
        $arr_data = [];
        if ($result -> num_rows > 0) {
            // 輸出數據
            while($row = $result->fetch_assoc()) {
                $restaurant = array(
                    "RestaurantID" => $row["Restaurant_ID"], 
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
                    "wordpressLink" => $row['wordpress_link']
                );
                array_push($arr_data, $restaurant);
            }
        }
        return $arr_data;
    }

    function get_restaurant_info($todayDate, $time, $type, $price, $userLocation, $dist){
        global $link;
    //     // 篩選動作 (依 使用者偏好的選項 進行篩選)
    //     // 將 puli_restaurant, puli_rest_time 資料表做連接    
    //     // JOIN 結合多個資料表，組成一個暫時性的資料表 供查詢
        $f_sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
        puli_restaurant.Restaurant_intro, puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
        puli_restaurant.Restaurant_comment, puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
        puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y 
        FROM puli_restaurant 
        LEFT JOIN puli_rest_time on puli_restaurant.Restaurant_ID = puli_rest_time.Restaurant_ID 
        LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID 
        WHERE puli_rest_time.Day_ID = '".$todayDate."'  ";

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
            // print_r($min_max);
            if ($min_max[1] == ""){
                $min_max[1] = 100000;
            }
            else if ($min_max[0] == ""){
                $min_max[0] = 0;
            }
            
            $f_sql = $f_sql . "AND puli_restaurant.Restaurant_price >= '".$min_max[0]."' 
            AND puli_restaurant.Restaurant_price <= '".$min_max[1]."'";
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
                $dis = explode(" ", $dist);
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
        return $final_data;
    }

    function add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhotoUrl, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY){
        global $link;
        $sql_create = "INSERT INTO puli_restaurant 
        ( Restaurant_name, Restaurant_TEL, Restaurant_intro, Restaurant_time, Restaurant_photo, Restaurant_comment, Restaurant_price, Restaurant_address, Restaurant_x, Restaurant_y)
        VALUES
        ( '$RestaurantName', '$RestaurantTEL', '$RestaurantIntro', '$RestaurantTime', '$RestaurantPhotoUrl', '$RestaurantComment', '$RestaurantPrice', '$RestaurantAddress', '$RestaurantX', '$RestaurantY')";

        return mysqli_query($link, $sql_create);
    }

    function update_restaurant_info($RestaurantID, $RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhoto, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY){
        global $link;
        //更新資料庫資料語法
        if($RestaurantPhoto != "" && $RestaurantPhoto != null){
            $sql_update = "UPDATE puli_restaurant SET 
            Restaurant_name = '$RestaurantName', Restaurant_TEL = '$RestaurantTEL', 
            Restaurant_intro = '$RestaurantIntro', Restaurant_time = '$RestaurantTime',
            Restaurant_photo = '$RestaurantPhoto', Restaurant_comment = '$RestaurantComment',
            Restaurant_price = '$RestaurantPrice', Restaurant_address = '$RestaurantAddress',
            Restaurant_x = '$RestaurantX', Restaurant_y = '$RestaurantY'
            WHERE Restaurant_ID = '$RestaurantID'";
        }else{
            $sql_update = "UPDATE puli_restaurant SET 
            Restaurant_name = '$RestaurantName', Restaurant_TEL = '$RestaurantTEL', 
            Restaurant_intro = '$RestaurantIntro', Restaurant_time = '$RestaurantTime', Restaurant_comment = '$RestaurantComment',
            Restaurant_price = '$RestaurantPrice', Restaurant_address = '$RestaurantAddress',
            Restaurant_x = '$RestaurantX', Restaurant_y = '$RestaurantY'
            WHERE Restaurant_ID = '$RestaurantID'";
        }
        echo $sql_update;
        return mysqli_query($link, $sql_update);
    }

    function delete_restaurant_info($RestaurantID){
        global $link;
        // 搜尋資料庫資料
        $sql = "SELECT * FROM puli_restaurant Where Restaurant_ID = '$RestaurantID'";
        // 執行查詢 mysqli_query(連接要使用的MySQL, 要查詢的資料)
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) {
            $sql_delete = "DELETE FROM puli_restaurant WHERE Restaurant_ID = $RestaurantID";
            if(mysqli_query($link,$sql_delete)){
                return TRUE;
            }else{
                return "資料庫錯誤";
            }
        }else{
            return "查無資料";
        }
    }
    

?>