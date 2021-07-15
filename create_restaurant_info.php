<?php
    session_start(); 
    require_once("../model/restaurant.php");

    // 取得使用者想新增的資料餐廳資料
    $RestaurantName = $_POST['RestaurantName'];
    $RestaurantTEL = $_POST['RestaurantTEL'];
    $RestaurantTime = $_POST['RestaurantTime'];
    // $RestaurantPhoto = $_POST['RestaurantPhoto'];
    $RestaurantPrice = $_POST['RestaurantPrice'];
    $RestaurantAddress = $_POST['RestaurantAddress'];
    $RestaurantX = $_POST['RestaurantX'];
    $RestaurantY = $_POST['RestaurantY'];
    $BlogURL = $_POST['BlogURL'];
    $CategoryName = $_POST['CategoryName'];

    // 抓那一欄資料
    // 身分驗證
    // if ($_SESSION['user_login'] == $row['user_login']) {
    if(isset($_SESSION['userLogin'])) {
        if(file_exists($_FILES['RestaurantPhoto']['tmp_name']) && is_uploaded_file($_FILES['RestaurantPhoto']['tmp_name'])){
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["RestaurantPhoto"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["RestaurantPhoto"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $msg = "File is not an image.";
                    echo $msg;
                    // $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $msg = "Sorry, file already exists.";
                echo $msg;
                // $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["RestaurantPhoto"]["size"] > 2097152) {
                $msg = "Sorry, your file is too large. (>2 Mb)";
                echo $msg;
                // $uploadOk = 0;  
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                echo $msg;
                // $uploadOk = 0;  
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg = "Sorry, your file was not uploaded.";
                echo $msg;
                // if everything is ok, try to upload file
            } else {
                echo $target_file;
                if (move_uploaded_file($_FILES["RestaurantPhoto"]["tmp_name"], $target_file)) {
                    if(add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, "uploads/".basename($_FILES["RestaurantPhoto"]["name"]), $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName))
                    {
                        header('Location: '."../view/MapEdit.php");
                    }
                    else{
                        echo "新增失敗";
                    }
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                    echo $msg;
                }
            } 
        } else {
            if(add_restaurant_info($RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, "", $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName))
            {
                header('Location: '."../view/MapEdit.php");
            }
            else{
                echo "新增失敗";
            }
        }
    } 
    else {
        header('Location: '."../view/LoginPage.php");
    }
?>