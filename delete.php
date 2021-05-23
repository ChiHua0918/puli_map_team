<!-- php session_start();  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("login.php"); // 連接login.php 以核對權限
// include("read.php"); // 取得餐廳資料 (以便刪除餐廳資料用)

// 取得使用者想刪除的餐廳名字
@$RestaurantID = $_GET['RestaurantID'];
// @$RestaurantID = $_POST['RestaurantID'];

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
            // $RestaurantID = $row['Restaurant_ID'];
            
            $sql_delete = "DELETE FROM puli_restaurant WHERE Restaurant_ID = $RestaurantID";
            mysqli_query($link,$sql_delete);
            
            echo " " . $row['Restaurant_ID']. " " 
            . $row['Restaurant_name']. " "
            . '刪除成功!';
            // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
        else
        {
            echo '刪除失敗!';
            // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
    }
}
else
{
    echo '您無權限觀看此頁面!';
    // echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
?>