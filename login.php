<?php session_start(); ?>
    <!--上方語法為啟用session，此語法要放在網頁最前方-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    //連接資料庫
    //只要此頁面上有用到連接MySQL就要include connect.php
    include("connect.php");
    // 取得使用者輸入的帳號、密碼
    @$userLogin = $_POST['userLogin'];
    @$userPass = $_POST['userPass'];

    // 搜尋資料庫資料
    $sql = "SELECT * FROM wp_users Where user_login = '$userLogin'";
    // 執行查詢 mysqli_query(連接要使用的MySQL, 要查詢的資料)
    $result = mysqli_query($link, $sql);
    require_once ('C:\xampp\htdocs\wordpress\wp-includes\class-phpass.php');
    $wp_hasher= new PasswordHash(8, TRUE);
    while($row = mysqli_fetch_assoc($result)){
        // 資料庫加密過後的密碼
        $db_password = $row['user_pass'];
        // 解密驗證 check CheckPassword(使用者輸入密碼,資料庫加密過後的密碼);
        $checkPassword = $wp_hasher -> CheckPassword($userPass,$db_password);
        // 登入成功
        // 判斷帳號與密碼是否為空白 以及確認是否為MySQL資料庫裡是否有這個會員
        if($userLogin != null && $userPass != null && $row['user_login'] == $userLogin && $checkPassword == 1)
        {
            // 將帳號寫入session，方便驗證使用者身份
            // session 內儲存 user-login(帳號)
            $_SESSION['userLogin'] = @$userLogin;
            
            // 將user_status改成1 
            $sql_online = "UPDATE wp_users SET user_status = 1 Where user_login = '$userLogin'";
            mysqli_query($link,$sql_online);
            
            echo $row["user_login"];
            echo '登入成功!';
            header("location=http://localhost:8080/github/puli_map_team/mapEdit.php");
        }
        
        else // 登入失敗
        {
            echo $row["user_login"];
            echo '登入失敗!';
            echo "<script>alert('登入失敗');</script>";
            header("Refresh:0;url=http://localhost:8080/github/puli_map_team/loginWebsite.php");

        }
    }

?>