<?php
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:POST, GET');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type'); 

    // fetch data 連接 puli_restaurant 取得資料
    // 傳json格式給地圖
    require_once("../model/restaurant.php");
    echo json_encode(get_all_restaurant_info(), JSON_NUMERIC_CHECK);
?>
