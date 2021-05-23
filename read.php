<!-- fetch data 連接 puli_restaurant 取得資料 -->
<?php
    // db_host, db_username, db_password, db_name
    $link = mysqli_connect("localhost","root","","wordpress"); 
    if ($link == false) {
        die("連接失敗: " .mysqli_connect_error());
    }
    // $sql 加入sql語法 從 user 的資料表中選擇所有欄位
    $sql = "SELECT * FROM puli_restaurant";

    // 以下程式是將DB中的資料印出來
    // $result 從DB中取出結果集
    // -> 取得 $link 中的 query($sql)
    $result = $link->query($sql);
    // $row = mysqli_fetch_assoc($result);
    
    $arr_data = [];
    if ($result -> num_rows > 0) {
        // 輸出數據
        // echo "id: "."     "."Name: "."      "."username: ". "<br>";
        // -> 引用一個class的屬性和方法
        while($row = $result->fetch_assoc()) {
            $restaurant = array
            (
                " RestaurantID " => $row["Restaurant_ID"], 
                " RestaurantName " => $row["Restaurant_name"],
                " RestaurantTEL " => $row["Restaurant_TEL"], 
                " RestaurantIntro " => $row["Restaurant_intro"], 
                " RestaurantTime " => $row["Restaurant_time"], 
                " RestaurantPhoto " => $row["Restaurant_photo"], 
                " RestaurantComment	 " => $row["Restaurant_comment"], 
                " RestaurantPrice " => $row["Restaurant_price"], 
                " RestaurantAddress " => $row["Restaurant_address"], 
                " RestaurantX " => $row["Restaurant_x"], 
                " RestaurantY " => $row["Restaurant_y"]
            );
            array_push($arr_data,$restaurant);
        }
    } else {
        echo "0 結果";
    }
    print_r($arr_data);
    mysqli_query($link, "SET sNAMES 'utf8'");  //設定資料庫編碼 utf8

// $link->close();
?>

