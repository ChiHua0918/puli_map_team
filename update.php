<!-- php session_start();  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    include("login.php");

    @$RestaurantID = $_GET['RestaurantID'];
//     @$RestaurantID = $_POST['RestaurantID'];

    @$key = $_GET['key'];
    @$val = $_GET['val'];

    echo $_SESSION['userLogin'];

//紅色字體為判斷密碼是否填寫正確
if(isset($_SESSION['userLogin']))
{
        //更新資料庫資料語法
        $sql_update = "UPDATE puli_restaurant SET 
        $key = '$val'
        WHERE Restaurant_ID = '$RestaurantID'";

        if(mysqli_query($link, $sql_update))
        {
                echo '修改成功!';
                // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
        else
        {
                echo '修改失敗!';
                // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
}
else
{
        echo '您無權限觀看此頁面!';
        // echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
?>