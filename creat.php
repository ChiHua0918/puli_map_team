<!-- 新增」餐廳MySQL資料庫 (create.php) -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("login.php");
// 1. 防呆 不要有空的 -> 方法post
// 2. 新增儲存按鈕、刪除按鈕
// 取得使用者想新增的資料餐廳資料
@$Restaurant_name = $_POST['Restaurant_name'];
@$Restaurant_TEL = $_POST['Restaurant_TEL'];
@$Restaurant_intro = $_POST['Restaurant_intro'];
@$Restaurant_time = $_POST['Restaurant_time'];
@$Restaurant_photo = $_POST['Restaurant_photo'];
@$Restaurant_comment = $_POST['Restaurant_comment'];
@$Restaurant_price = $_POST['Restaurant_price'];
@$Restaurant_address = $_POST['Restaurant_address'];
@$Restaurant_x = $_POST['Restaurant_x'];
@$Restaurant_y = $_POST['Restaurant_y'];

// 抓那一欄資料
// 身分驗證
if (isset($_SESSION['user_login']) && $Restaurant_name != NULL && $Restaurant_TEL != NULL && $Restaurant_address != NULL && $Restaurant_x != NULL && $Restaurant_y != NULL) {
  $sql_create = "INSERT INTO puli_restaurant 
    ( Restaurant_name, Restaurant_TEL, Restaurant_intro, Restaurant_time, Restaurant_photo, Restaurant_comment, Restaurant_price, Restaurant_address, Restaurant_x, Restaurant_y)
    VALUES
    ( '$Restaurant_name', '$Restaurant_TEL', '$Restaurant_intro', '$Restaurant_time', '$Restaurant_photo', '$Restaurant_comment', '$Restaurant_price', '$Restaurant_address', '$Restaurant_x', '$Restaurant_y')";

  if (mysqli_query($link, $sql_create)) {
    echo '新增成功!';
  } else {
    echo '新增失敗!';
  }
} else {
  echo '您無權限觀看此頁面!';
}
?>