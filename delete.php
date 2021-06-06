<?php
include("login.php"); // 連接login.php 以核對權限

// 取得使用者想刪除的餐廳名字
$RestaurantID = $_POST['RestaurantID'];

// 搜尋資料庫資料
$sql = "SELECT * FROM puli_restaurant Where Restaurant_ID = '$RestaurantID'";
// 執行查詢 mysqli_query(連接要使用的MySQL, 要查詢的資料)
$result = mysqli_query($link, $sql);

echo $_SESSION['userLogin'];

// 核對權限
if(isset($_SESSION['userLogin']))
{
    while($row = mysqli_fetch_assoc($result)){
        // 刪除資料庫資料
        // 餐廳資料不為null且有資料
        if($RestaurantID != null && $row['Restaurant_ID'] == $RestaurantID)
        {
            $sql_delete = "DELETE FROM puli_restaurant WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_delete);
            $sql_D_rest = "DELETE FROM puli_rest_time WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_D_rest);
            $sql_recommend = "DELETE FROM puli_recommend WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_recommend);

            echo " " . $row['Restaurant_ID']. " " 
            . $row['Restaurant_name']. " "
            . '刪除成功!';
            echo "<script>alert('刪除成功');</script>";
        }
        else
        {
            echo '刪除失敗!';
            echo "<script>alert('刪除失敗');</script>";
        }
    }
}
else
{
    echo '您無權限觀看此頁面!';
    echo "<script>alert('您無權限觀看此頁面!');
    </script>";
}
header("Refresh:0;url=/html/login/mapEdit.php");
?>