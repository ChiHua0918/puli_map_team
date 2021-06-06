<?php
    session_start(); 
    require_once("../model/restaurant.php");

    // 取得使用者想刪除的餐廳id
    $RestaurantID = $_GET['rid'];

    // 核對權限
    if(isset($_SESSION['userLogin'])){
        if($RestaurantID == null){
            echo "請輸入編號";
        }else{
            $result = delete_restaurant_info($RestaurantID);
            if($result === TRUE){
                header('Location: '."/view/MapEdit.php");
            }else{
                echo $result;
            }
        }
    }
    else{
        header('Location: '."/view/LoginPage.php");
    }
?>