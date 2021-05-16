<!-- php session_start();  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// 連接login.php 以 核對權限
include("login.php");

// 取得使用者想刪除的餐廳名字
@$Restaurant_ID = $_POST['Restaurant_ID'];
// 搜尋資料庫資料與使用者想刪除的餐廳名稱核對
$sql = "SELECT * FROM puli_restaurant Where Restaurant_ID = '$Restaurant_ID'";
//執行查詢 mysqli_query(連接要使用的MySQL, 要查詢的資料)
$result = mysqli_query($link, $sql);
// 顯示使用者名稱(方便察看是誰執行刪掉餐廳的動作)
echo $_SESSION['user_login'];
// 核對權限
if(isset($_SESSION['user_login']))
{
    echo '</br>'.'刪除餐廳資訊:'.'</br>';
    while($row = mysqli_fetch_assoc($result)){
        // 刪除資料庫資料
        // 餐廳資料不為null且有資料
        if($Restaurant_ID != null && $row['Restaurant_ID'] == $Restaurant_ID)
        {
            // $Restaurant_ID = $row['Restaurant_ID'];
            $Restaurant_name = $row['Restaurant_name'];
            $sql_delete = "DELETE FROM puli_restaurant WHERE Restaurant_ID = $Restaurant_ID";
            mysqli_query($link,$sql_delete);
            
            echo '</br>'.'ID:'.$Restaurant_ID."</br>"."Name:".$Restaurant_name.'</br>';
            echo '刪除成功!'.'</br>';
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