<?php
include("login.php");

// 取得使用者想新增的資料餐廳資料
$RestaurantName = $_POST['RestaurantName'];
$RestaurantTEL = $_POST['RestaurantTEL'];
$RestaurantTime = $_POST['RestaurantTime'];
$RestaurantPhoto = $_POST['RestaurantPhoto'];
$RestaurantPrice = $_POST['RestaurantPrice'];
$RestaurantAddress = $_POST['RestaurantAddress'];
$RestaurantX = $_POST['RestaurantX'];
$RestaurantY = $_POST['RestaurantY'];
$wordpressLink = $_POST['wordpressLink'];
$CategoryName = $_POST['CategoryName'];

echo $_SESSION['userLogin'];
// 身分驗證
if (isset($_SESSION['userLogin'])) {
  // 新增至puli_restaurant資料表
  $sql_create = "INSERT INTO puli_restaurant 
    ( Restaurant_name, Restaurant_TEL, Restaurant_time, Restaurant_photo, Restaurant_price, Restaurant_address, Restaurant_x, Restaurant_y, wordpress_link)
    VALUES
    ( '$RestaurantName', '$RestaurantTEL', '$RestaurantTime', '$RestaurantPhoto', '$RestaurantPrice', '$RestaurantAddress', '$RestaurantX', '$RestaurantY', '$wordpressLink')";
  if (mysqli_query($link, $sql_create)) {
    echo " " . $RestaurantName . " ";
    echo '新增成功!';
    echo "<script>alert('新增成功');</script>";
  } else {
    echo '新增失敗!';
    echo "<script>alert('新增失敗');</script>";
  }

  // 先抓取餐廳那一欄資料(主要想抓ID)
  $sql_fetch = "SELECT Restaurant_ID FROM puli_restaurant WHERE Restaurant_name = '$RestaurantName'";
  $result = mysqli_query($link, $sql_fetch);
  while ($row = $result->fetch_assoc()) {
    $RestaurantID = $row['Restaurant_ID'];
  }
  echo $RestaurantID;
  // -------------新增 puli_recommend---------------
  echo gettype($CategoryName);
  foreach ($CategoryName as $value){
    $sql_recommend = "INSERT INTO puli_recommend (Restaurant_ID,Category_name) VALUES ('$RestaurantID','$value')";
    if (mysqli_query($link, $sql_recommend)) {
      echo "新增類別成功";
    } else if (mysqli_query($link, $sql_recommend) == false){
      echo "新增類別失敗";
    }
  }
  // --------------新增 puli_rest_time---------------
  // 分割星期幾的時間(輸入ex:星期日 13:00~14:00 15:00~16:00,星期一 13:00~14:00)
  $week = explode(",", $RestaurantTime);
  // 分割該星期和營業時間(輸入ex:星期一 13:00~14:00)
  for ($i = 0; $i < 7; $i++) {
    // $time = [];
    // array_push($time, explode(" ", $week[$i]));
    $time = explode(" ", $week[$i]);
    print_r($time);
    // 轉換星期->數字
    $arr_week = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
    for ($j = 0; $j < 7 ; $j++){
      if ($time[0] == $arr_week[$j]){
        $DayID = $j; //星期幾
      }
    } 
    echo $DayID;
    for ($t = 1; $t < count($time); $t++) { //營業時段
      // 如果是公休或是時間不固定
      if ($time[$t] == "公休" || $time[$t] == "營業時間不固定"){
        break;
      }
      // 分割開始營業&結束
      $StartEnd = explode("~", $time[$t]);
      $openTime = $StartEnd[0];
      $endTime = $StartEnd[1];
      $sql_rest_time = "INSERT INTO puli_rest_time
        ( Day_ID, Restaurant_ID, open_time, end_time) VALUES( '$DayID', '$RestaurantID', '$openTime', '$endTime')";
      // 新增至資料表
      if (mysqli_query($link, $sql_rest_time)) {
        echo "已新增時間";
      }
    }
  }
} else {
  echo '您無權限觀看此頁面!';
  echo "<script>alert('您無權限觀看此頁面!');</script>";
}
header("Refresh:0;url=/html/login/mapEdit.php");
