<?php
    session_start(); 
    require_once("../model/user.php");
    
    // 取得使用者輸入的帳號、密碼
    $userLogin = $_POST['userLogin'];
    $userPass = $_POST['userPass'];

    // 將帳號寫入session，方便驗證使用者身份
    // session 內儲存 user-login(帳號)
    if (login($userLogin, $userPass)){
        $_SESSION['userLogin'] = $userLogin;
        header('Location: '."/view/MapEdit.php");
    }else{
        echo "帳號或密碼錯誤，請重新登入。";
    }
    
?>