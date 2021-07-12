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
        $sql = "SELECT DISTINCT puli_restaurant.Restaurant_ID, puli_restaurant.Restaurant_name, puli_restaurant.Restaurant_TEL, 
        puli_restaurant.Restaurant_intro, puli_restaurant.Restaurant_time, puli_restaurant.Restaurant_photo, 
        puli_restaurant.Restaurant_comment, puli_restaurant.Restaurant_price, puli_restaurant.Restaurant_address, 
        puli_restaurant.Restaurant_x, puli_restaurant.Restaurant_y, puli_restaurant.Blog_URL,puli_recommend.Category_name
        FROM puli_restaurant
        LEFT JOIN puli_rest_time on puli_rest_time.Restaurant_ID = puli_restaurant.Restaurant_ID
        LEFT JOIN puli_recommend on puli_recommend.Restaurant_ID = puli_restaurant.Restaurant_ID ";
        $result = $link->query($sql);
        $arr_data = [];
        $addCategory = "";
        $check = 0;
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
                    "BlogURL" => $row['Blog_URL'],
                    "CategoryName" => $row['Category_name']
                );
                if ($check == $row["Restaurant_ID"]){
                    $addCategory .= "、".$row['Category_name'];
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
            if ($min_max[1] == ""){
                $min_max[1] = 100000;
            }
            else if ($min_max[0] == ""){
                $min_max[0] = 0;
            }
            $min = $min_max[0];
            $max = $min_max[1];
            $f_sql = $f_sql . "AND puli_restaurant.Restaurant_price >= $min
            AND puli_restaurant.Restaurant_price <= $max";
        }

        // $result 從DB中取出結果集
        $result = $link->query($f_sql);
        // print_r($result) ;
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
            if ($dist != "" && count($arr_fl_data) != 0){
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
        return $arr_fl_data;
    }

    function add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhotoUrl, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName){
        global $link;
        $sql_create = "INSERT INTO puli_restaurant 
        ( Restaurant_name, Restaurant_TEL, Restaurant_intro, Restaurant_time, Restaurant_photo, Restaurant_comment, Restaurant_price, Restaurant_address, Restaurant_x, Restaurant_y, Blog_URL)
        VALUES
        ( '$RestaurantName', '$RestaurantTEL', '$RestaurantIntro', '$RestaurantTime', '$RestaurantPhotoUrl', '$RestaurantComment', '$RestaurantPrice', '$RestaurantAddress', '$RestaurantX', '$RestaurantY', '$BlogURL')";

        if(mysqli_query($link, $sql_create)){
            $sql_fetch = "SELECT Restaurant_ID FROM puli_restaurant WHERE Restaurant_name = '$RestaurantName'";
            $result = mysqli_query($link, $sql_fetch);
            while ($row = $result->fetch_assoc()) {
                $RestaurantID = $row['Restaurant_ID'];
            }
        }else{
            return FALSE;
        }
        // -------------新增 puli_recommend---------------
        echo gettype($CategoryName);
        foreach ($CategoryName as $value) {
          $sql_recommend = "INSERT INTO puli_recommend (Restaurant_ID,Category_name) VALUES ('$RestaurantID','$value')";
          if (mysqli_query($link, $sql_recommend)) {
            echo "新增類別成功";
          } else if (mysqli_query($link, $sql_recommend) == false) {
            echo "新增類別失敗";
          }
        }
        echo "<script>console.log(CategoryName);</script>";

        // --------------新增 puli_rest_time---------------
        // 分割星期幾的時間(輸入ex:星期日 13:00~14:00 15:00~16:00,星期一 13:00~14:00)
        $week = explode(",", $RestaurantTime);
        // 分割該星期和營業時間(輸入ex:星期一 13:00~14:00)
        for ($i = 0; $i < 7; $i++) {
            // $time = [];
            // array_push($time, explode(" ", $week[$i]));
            $time = explode(" ", $week[$i]);
            // 轉換星期->數字
            $arr_week = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
            for ($j = 0; $j < 7 ; $j++){
                if ($time[0] == $arr_week[$j]){
                    $DayID = $j; //星期幾
                    break;
                }
            } 
            // echo $DayID;
            for ($t = 1; $t < count($time); $t++) { //營業時段
                // 如果是公休或是時間不固定
                if ($time[$t] == "公休" || $time[$t] == "營業時間不固定"){
                    break;
                }
                // 分割開始營業&結束
                $StartEnd = explode("~", $time[$t]);
                $openTime = $StartEnd[0];
                $endTime = $StartEnd[1];
                $sql_rest_time = "INSERT INTO puli_rest_time(Day_ID, Restaurant_ID, open_time, end_time) VALUES ('$DayID', '$RestaurantID', '$openTime', '$endTime')";
                // 新增至資料表
                mysqli_query($link, $sql_rest_time);
            }
        }
        return TRUE;
    }

    function update_restaurant_info($RestaurantID, $RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhotoUrl, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName){
        global $link;
        //更新資料庫資料語法
        if($RestaurantPhotoUrl != "" && $RestaurantPhotoUrl != null){
            delete_restaurant_info($RestaurantID);
            add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhotoUrl, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName);
        } else {
            $sql = "SELECT Restaurant_photo FROM puli_restaurant Where Restaurant_ID = '$RestaurantID'";
            $result = mysqli_query($link, $sql);
            $row = $result->fetch_assoc();
            $RestaurantPhotoUrl = $row["Restaurant_photo"];
            delete_restaurant_info($RestaurantID);
            add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, $RestaurantPhotoUrl, $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName);
        }
        return TRUE;
    }

    function delete_restaurant_info($RestaurantID){
        global $link;
        // 搜尋資料庫資料
        $sql = "SELECT * FROM puli_restaurant Where Restaurant_ID = '$RestaurantID'";
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) {
            $sql_delete = "DELETE FROM puli_restaurant WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_delete);
        }
        $sql = "SELECT * FROM puli_rest_time Where Restaurant_ID = '$RestaurantID'";
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) {
            $sql_D_rest = "DELETE FROM puli_rest_time WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_D_rest);
        }
        $sql = "SELECT * FROM puli_recommend Where Restaurant_ID = '$RestaurantID'";
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) {
            $sql_recommend = "DELETE FROM puli_recommend WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_recommend);
        }
        return TRUE;
    }
