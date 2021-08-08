<?php
    session_start(); 
    require_once("../model/restaurant.php");

    $RestaurantID = $_POST['RestaurantID'];
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
    
    
    //紅色字體為判斷密碼是否填寫正確
    if(isset($_SESSION['userLogin'])){
        if(file_exists($_FILES['RestaurantPhoto']['tmp_name']) && is_uploaded_file($_FILES['RestaurantPhoto']['tmp_name'])){
            // 如果原本沒有圖片
            $restaurant_photoUrl = get_restaurant_photoUrl_by_id($RestaurantID);
            echo "原本的".$restaurant_photoUrl."-----------------------------<br/>";
            echo gettype($restaurant_photoUrl)."<br/>";
            if ($restaurant_photoUrl == NULL){
                $restaurant_photoUrl = "../無";
            }
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
                if($restaurant_photoUrl != null){    //..,uploads,2D.png
                    // Check if file already exists
                    echo $restaurant_photoUrl;
                    if (file_exists($target_file)) {
                        echo $target_file."<br/>";
                        $file_name = explode("/",$restaurant_photoUrl)[1];
                        echo '<br/>'.$file_name;
                        echo '<br/>'.$_FILES["RestaurantPhoto"]["name"];

                        if($file_name == $_FILES["RestaurantPhoto"]["name"]){
                            $msg = "Sorry, file already exists.";
                            echo $msg;
                            echo "<script>alert('上傳到同一個檔案囉!'); location='../view/MapEdit.php';</script>";
                            // $uploadOk = 0;
                        }else{
                            unlink($target_file);
                            if (move_uploaded_file($_FILES["RestaurantPhoto"]["tmp_name"], $target_file)) {
                                if(update_restaurant_info($RestaurantID, $RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, "uploads/".basename($_FILES["RestaurantPhoto"]["name"]), $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName))
                                {
                                    header('Location: '."../view/MapEdit.php");
                                }
                                else{
                                    echo "更新失敗!";
                                }
                            } else {
                                $msg = "Sorry, there was an error uploading your file.";
                                echo $msg;
                            }
                        }
                    }else{
                        unlink("../".$restaurant_photoUrl);
                        if (move_uploaded_file($_FILES["RestaurantPhoto"]["tmp_name"], $target_file)) {
                            if(update_restaurant_info($RestaurantID, $RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, "uploads/".basename($_FILES["RestaurantPhoto"]["name"]), $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName))
                            {
                                header('Location: '."../view/MapEdit.php");
                            }
                            else{
                                echo "更新失敗!";
                            }
                        } else {
                            $msg = "Sorry, there was an error uploading your file.";
                            echo $msg;
                        }
                    }
                }
            }
        } else {
            if(update_restaurant_info($RestaurantID, $RestaurantName, $RestaurantTEL, $RestaurantIntro, $RestaurantTime, "", $RestaurantComment, $RestaurantPrice, $RestaurantAddress, $RestaurantX, $RestaurantY, $BlogURL, $CategoryName))
            {
                header('Location: '."../view/MapEdit.php");
            }
            else
            {
                echo "更新失敗!";
            }
        }
    }
    else
    {
        header('Location: '."../view/LoginPage.php");
    }
    
?>