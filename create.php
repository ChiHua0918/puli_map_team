<!-- 加入(註冊)會員 - 「新增」會員資料進MySQL資料庫 (register_finish.php) -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("login.php");

// 取得使用者想新增的資料餐廳資料
    @$RestaurantName = $_POST['RestaurantName'];
    @$RestaurantTEL = $_POST['RestaurantTEL'];
    @$RestaurantIntro = $_POST['RestaurantIntro'];
    @$RestaurantTime = $_POST['RestaurantTime'];
    @$RestaurantPhoto = $_POST['RestaurantPhoto'];
    @$RestaurantComment = $_POST['RestaurantComment'];
    @$RestaurantPrice = $_POST['RestaurantPrice'];
    @$RestaurantAddress = $_POST['RestaurantAddress'];
    @$RestaurantX = $_POST['RestaurantX'];
    @$RestaurantY = $_POST['RestaurantY'];


echo $_SESSION['userLogin'];
// 抓那一欄資料
// 身分驗證
// if ($_SESSION['user_login'] == $row['user_login']) {
if (isset($_SESSION['userLogin'])) {
    $sql_create = "INSERT INTO puli_restaurant 
    ( Restaurant_name, Restaurant_TEL, Restaurant_intro, Restaurant_time, Restaurant_photo, Restaurant_comment, Restaurant_price, Restaurant_address, Restaurant_x, Restaurant_y)
    VALUES
    ( '$RestaurantName', '$RestaurantTEL', '$RestaurantIntro', '$RestaurantTime', '$RestaurantPhoto', '$RestaurantComment', '$RestaurantPrice', '$RestaurantAddress', '$RestaurantX', '$RestaurantY')";
    // mysqli_query($link, $sql_create);
    if(mysqli_query($link, $sql_create)){
      echo " " . $RestaurantName . " " ;
      echo '新增成功!';
      // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
    }
    else{
      echo '新增失敗!';
      // echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
    }
} 
else {
  echo '您無權限觀看此頁面!';
}
?>
