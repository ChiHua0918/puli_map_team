<!-- 登出 - 洗掉登入使用者之session(logout.php) -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    include('con_puli_db.php');
    include('login.php');
    
    $user_login = $_SESSION['user_login'];
    // 把狀態改成不再線上 -> 將user_status改成0
    $sql_offline = "UPDATE puli_manager SET user_status = 0 Where user_login = '$user_login'";
    mysqli_query($link,$sql_offline);
    //將session清空
    // unset($_SESSION['user_login']);
    echo '登出中......';
?>