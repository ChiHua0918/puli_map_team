<!-- 登出 - 洗掉登入使用者之session(logout.php) -->
<!--  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    include('connect.php');
    include('login.php');
    // 如果網頁關掉 ， 1:連線由使用者或是網路終止
    
    echo $_SESSION['userLogin'];
    
    $userLogin = $_SESSION['userLogin'];
    // 把狀態改成不再線上
    // 將user_status改成0
    $sql_offline = "UPDATE puli_manager SET user_status = 0 Where user_login = '$userLogin'";
    mysqli_query($link,$sql_offline);
    
    //將session清空
    unset($_SESSION['userLogin']);

    echo '登出中......';
    // echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
?>