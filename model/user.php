<?php
    require_once("connect_db.php");
    require_once('/var/www/foodmap/wp-includes/class-phpass.php');

    function login($userLogin, $userPass){
        global $link;
        // 搜尋資料庫資料
        $sql = "SELECT * FROM wp_users WHERE user_login = '$userLogin'";
        // 執行查詢 mysqli_query(連接要使用的MySQL, 要查詢的資料)
        $result = mysqli_query($link, $sql);
        $wp_hasher = new PasswordHash(8, TRUE);
        $check = FALSE;
        while($row = mysqli_fetch_assoc($result)){
            // 資料庫加密過後的密碼
            $db_password = $row['user_pass'];
            // 解密驗證 check CheckPassword(使用者輸入密碼,資料庫加密過後的密碼);
            $checkPassword = $wp_hasher -> CheckPassword($userPass,$db_password);
            // 登入成功
            // 判斷帳號與密碼是否為空白 以及確認是否為MySQL資料庫裡是否有這個會員
            if($checkPassword){
                if($userLogin != null && $row['user_login'] == $userLogin)
                {
                    $check = TRUE;
                }
            }
        }
        if($check){
            // 將user_status改成1 
            $sql_online = "UPDATE wp_users SET user_status = 1 Where user_login = '$userLogin'";
            mysqli_query($link, $sql_online);
        }
        return $check;
    }
    
    function wp_logout($userLogin){
        global $link;
        // 把狀態改成不再線上
        // 將user_status改成0
        $sql_offline = "UPDATE wp_users SET user_status = 0 Where user_login = '$userLogin'";
        return mysqli_query($link, $sql_offline);
    }
    
?>