<?php 
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:POST, GET');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type'); 

    require_once("../model/restaurant.php");

    // 使用者在下拉式選單選的條件
    // 時間 
    $time = $_GET["time"];
    // 類別
    $type = $_GET['type'];
    // 價錢
    $price = $_GET['price'];
    // 使用者目前位置
    $userLocation = $_GET['userLocation'];
    // 距離範圍
    $dist = $_GET['dist'];

    // 判斷今天星期幾
    $todayDate = date("w");

    echo json_encode(get_restaurant_info($todayDate, $time, $type, $price, $userLocation, $dist));//, JSON_NUMERIC_CHECK);
?>