<?php
include("login.php");
include("delete.php");
include("create.php");
// $RestaurantID = $_POST['RestaurantID'];
// $RestaurantName = $_POST['RestaurantName'];
// $RestaurantTEL = $_POST['RestaurantTEL'];
// $RestaurantIntro = $_POST['RestaurantIntro'];
// $RestaurantTime = $_POST['RestaurantTime'];
// $RestaurantPhoto = $_POST['RestaurantPhoto'];
// $RestaurantComment = $_POST['RestaurantComment'];
// $RestaurantPrice = $_POST['RestaurantPrice'];
// $RestaurantAddress = $_POST['RestaurantAddress'];
// $RestaurantX = $_POST['RestaurantX'];
// $RestaurantY = $_POST['RestaurantY'];
// $wordpressLink = $_POST['wordpressLink'];
// $CategoryName = $_POST['CategoryName'];

// echo $_SESSION['userLogin'];

// //紅色字體為判斷密碼是否填寫正確
// if (isset($_SESSION['userLogin'])) {
//     //更新資料庫資料語法
//     $sql_update = "UPDATE puli_restaurant SET 
//         Restaurant_name = '$RestaurantName', Restaurant_TEL = '$RestaurantTEL', 
//         Restaurant_intro = '$RestaurantIntro', Restaurant_time = '$RestaurantTime',
//         Restaurant_photo = '$RestaurantPhoto', Restaurant_comment = '$RestaurantComment',
//         Restaurant_price = '$RestaurantPrice', Restaurant_address = '$RestaurantAddress',
//         Restaurant_x = '$RestaurantX', Restaurant_y = '$RestaurantY',
//         wordpress_link = '$wordpressLink'
//         WHERE Restaurant_ID = '$RestaurantID'";
//     // 更新puli_recommend
//     $sql_recommend = "UPDATE puli_recommend SET 
//         Category_name = '$CategoryName' WHERE Restaurant_ID = '$RestaurantID'";
//     // 更新puli_rest_time
//     // 分割星期幾的時間(輸入ex:星期日 13:00~14:00 15:00~16:00,星期一 13:00~14:00)
//     $week = explode(",", $RestaurantTime);
//     // 分割該星期和營業時間(輸入ex:星期一 13:00~14:00)
//     for ($i = 0; $i < 7; $i++) {
//         // $time = [];
//         // array_push($time, explode(" ", $week[$i]));
//         $time = explode(" ", $week[$i]);
//         print_r($time);
//         // 轉換星期->數字
//         $arr_week = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
//         for ($j = 0; $j < 7; $j++) {
//             if ($time[0] == $arr_week[$j]) {
//                 $DayID = $j; //星期幾
//             }
//         }
//         for ($t = 1; $t < count($time); $t++) { //營業時段
//             // 分割開始營業&結束
//             $StartEnd = explode("~", $time[$t]);
//             $openTime = $StartEnd[0];
//             $endTime = $StartEnd[1];
//             $sql_rest = "UPDATE puli_rest_time SET 
//             open_time = '$openTime', end_time = '$endTime'  
//             WHERE Restaurant_ID = '$RestaurantID' and Day_ID = '$DayID'";
//         }
//     }

    

//     if (mysqli_query($link, $sql_update)) {
//         echo '修改成功!';
//         echo "<script>alert('修改成功');</script>";
//     }
//     if (mysqli_query($link, $sql_recommend)){
//         echo "類別成功";
//     }
//     if (mysqli_query($link, $sql_rest)){
//         echo "時間成功";
//     }
//     else {
//         echo '修改失敗!';
//         echo "<script>alert('修改失敗');</script>";
//     }
// } else {
//     echo '您無權限觀看此頁面!';
// }
header("Refresh:0;url=/html/login/mapEdit.php");
