<?php
    session_start(); 
    require_once("../model/user.php");
    // 如果網頁關掉 ， 1:連線由使用者或是網路終止
    
    $userLogin = $_SESSION['userLogin'];
    if(wp_logout($userLogin)){
        //將session清空
        unset($_SESSION['userLogin']);
        header('Location: '."/");
    }else{
        echo '資料庫發生錯誤';
    }
?>