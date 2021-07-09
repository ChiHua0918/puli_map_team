<?php
session_start();
if (!isset($_SESSION['userLogin'])) {
    header('Location: ' . "../view/LoginPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>埔里美食地圖 - 編輯頁面</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

    <style>
        html,
        body {
            height: 100vh;
            padding-bottom: 100px;
            background-image: url("../src/食物背景透明3.png");
            background-size: 100%;
        }

        #map_container {
            position: relative;
            z-index: 1;
            top: 40px;
            left: 3vw;
            width: 72vw;
            height: 90%;
        }

        #map {
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        .modify {
            width: 1200px;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.801);
            box-shadow: 0px 0px 3px hsla(240, 40%, 15%, 0.6);
            position: absolute;
            z-index: 2;
            right: 0%;
            text-align: center;
            transform: translateX(0);
            transition: all 0.5s;
        }

        ul {
            list-style-type: none;
        }

        /* @media screen and (min-width: 680px) {
            nav li:first-child {
                padding-left: 30px;
            }
            nav li {
                display: inline-block;
                padding-right: 30px;
            }
        }
        @media (min-width: 480px) and (max-width: 680px) {
            nav li {
                text-align: center;
            }
            nav ul {
                columns: 2;
                -webkit-columns: 2;
                -moz-columns: 2;
            }
        } */
        input[type=submit],
        button {
            vertical-align: middle;
            font-size: 14pt;
            font-family: times new roman;
            /* width: 60px;
            height: 35px; */
        }

        select,
        button {
            vertical-align: middle;
            font-size: 14pt;
            font-family: times new roman;
            /* width: 60px;
            height: 35px; */
        }

        #data {
            text-align: left;
            display: inline-block;
            line-height: 30pt;
        }

        .active {
            transform: translateX(1195px);
        }

        .btn {
            position: absolute;
            top: 50%;
            right: 1200px;
            padding: 40px 10px;
            background-color: rgba(255, 255, 255, 0.801);
            border-radius: 6px 0 0 6px;
            box-shadow: -1px 0px 2px hsla(240, 40%, 15%, 0.6);
        }

        .fa-chevron-right {
            color: #474747;
            transform: rotate(0);
            transition: all 0.5s;
        }

        .rotate {
            transform: rotate(180deg);
        }

        /* crud */
        .data {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .thead {}

        .tbody {}

        tr {
            border-bottom: 1px solid #cbcbcb;
        }

        th,
        td {
            height: 40px;
            padding: 2px;
        }

        tr:hover {
            background-color: rgba(235, 235, 235, 0.5);
        }

        .add_btn {
            position: fixed;
            top: 60px;
            right: 50px;
            text-decoration: none;
            padding: 3px 4px;
            background: #005AB5;
            color: white;
            border-radius: 3px;
        }

        .edit_btn {
            text-decoration: none;
            padding: 3px 4px;
            background: #2E8B57;
            color: white;
            border-radius: 3px;
            width: 50px;
            height: 35px;

        }

        a,
        .del_btn {
            text-decoration: none;
            font-size: 14pt;
        }

        a:hover,
        .del_btn {
            text-decoration: none;
            font-size: 14pt;
            color: white;
        }

        .del_btn {
            text-decoration: none;
            padding: 3px 4px;
            background: #800000;
            color: white;
            border-radius: 3px;
            width: 50px;
            height: 35px;
        }

        #dialog {
            display: none;
            width: 500px;
            height: 600px;
            position: fixed;
            margin-top: -50px;
            padding: 30px;
            /* border: 2px solid blue; */
            background-color: rgba(155, 212, 233, 0.9);
            z-index: 3;
            /* right: 35%;
            top: 15%; */
        }

        #dialog_content {
            vertical-align: middle;
            color: white;
        }

        #closeBtn {
            /* position:relative; */
            margin: 15px;
            text-decoration: none;
            padding: 3px 4px;
            background: red;
            color: white;
            border-radius: 3px;
            width: 50px;
            height: 35px;
            position: relative;
            top: -50px;
            left: 50px;
        }

        #main {
            width: 900px;
            margin: 0px auto;
            line-height: 28pt;
            font-size: 16pt;
        }

        legend {
            font-weight: bold;
            color: red;
        }

        input[type=submit],
        input[type=reset] {
            font-family: times new roman;
            font-size: 14pt;
            vertical-align: middle;
        }

        h2 {
            text-align: center;
            color: darkgreen;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light " style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand">foodmap</a>
            <a class="d-flex" href="../controller/logout.php"><i class="fas fa-user fa-2x"></i></a>
        </div>
    </nav>
    <div class="modify">
        <button class="btn"><i class="fas fa-chevron-right fa-2x"></i></button>

        <div id='map_container'>
            <div id='map'></div>
        </div>
    </div>
    <div id="main">
        <h2>新增餐廳</h2>
        <form action="../controller/create_restaurant_info.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>基本資料</legend>
                名稱: <input type="text" name="RestaurantName" required /><br />
                電話:
                <input type="tel" name="RestaurantTEL" required /><br />
                <!--簡介: <br/><textarea type="text" name="RestaurantIntro" required cols="4" rows="1" disabled>32145621345213</textarea> <br />-->
                營業時間: <br /><textarea type="text" name="RestaurantTime" required placeholder="ex:星期五 7:00~10:00,星期六 7:00~10:00" cols="20" rows="5" /></textarea> <br />
                Date: <input type="date" name="dte" /><br />
                照片: <input type="file" accept="image/*" multiple name="RestaurantPhoto" /><br />
                <!--評價: <input type="text" name="RestaurantComment" required /> <br/>-->
                價錢: <input type="text" name="RestaurantPrice" required /> <br />
                地址: <input type="text" name="RestaurantAddress" required size="100" /> <br />
                x座標: <input type="text" name="RestaurantX" required /> <br />
                y座標: <input type="text" name="RestaurantY" required /> <br />
                部落格網址: <input type="text" name="BlogURL" required placeholder="請先縮短網址" size="50" /> <br />
                食物類別:
                <select id="typeSelect" name="CategoryName" multiple>
                    <option value="冰品">冰品</option>
                    <option value="小吃">小吃</option>
                    <option value="點心">點心</option>
                    <option value="早餐">早餐</option>
                    <option value="東南亞">東南亞</option>
                    <option value="早午餐">早午餐</option>
                    <option value="美式">美式</option>
                    <option value="韓式">韓式</option>
                    <option value="日式">日式</option>
                    <option value="港式">港式</option>
                    <option value="宵夜">宵夜</option>
                    <option value="甜點">甜點</option>
                </select>
                <br />
            </fieldset>
            <input type="submit" value="新增餐廳" />
            <input type="reset" value="重填" />
        </form>
    </div>

</body>
<script src="https://kit.fontawesome.com/99bbad7d3f.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/themes/fa/theme.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/locales/LANG.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script>
    var id = [];
    var x = [];
    var y = [];
    var time = [];
    var tel = [];
    var photo = [];
    var restaurant_name = [];
    var price = [];
    var address = [];
    var blog_url = [];
    var category = [];
    var categoryList = ["冰品", "小吃", "點心", "早餐", "東南亞", "早午餐", "美式", "韓式", "日式", "港式", "宵夜", "甜點"];

    $(function() {
        // categoryTbl("");
        //存放各個marker的資訊，到時候從DB取出時可直接存成陣列
        // var x = [160,656,333,1003,786];
        // var y = [195,398,573,398,471];
        // var name = ["暨大管理學院","肯德基","日式拉麵店","雞排店","飲料店"];
        // var url = ["暨南cm.jpg","","","",""];
        fetch("../controller/get_all_restaurant_info.php")
            .then(res => {
                return res.json()
            })
            .then(result => {
                const bounds = [
                    [0, 0],
                    [730, 1600]
                ];
                const map = L.map('map', {
                    crs: L.CRS.Simple
                });
                map.setView([365, 800]);
                map.fitBounds(bounds);
                const image = L.imageOverlay('../src/puliMap2.png', bounds).addTo(map);

                // set my own marker icon
                const myIcon = L.icon({
                    iconUrl: '../src/markericon2.png',
                    iconSize: [34, 48],
                });

                console.log(result);

                for (let i = 0; i < result.length; i++) {
                    id.push(result[i].RestaurantID);
                    x.push(result[i].RestaurantX);
                    y.push(result[i].RestaurantY);
                    time.push(result[i].RestaurantTime);
                    tel.push(result[i].RestaurantTEL);
                    photo.push(result[i].RestaurantPhoto);
                    restaurant_name.push(result[i].RestaurantName);
                    price.push(result[i].RestaurantPrice);
                    address.push(result[i].RestaurantAddress);
                    blog_url.push(result[i].BlogURL);
                    category.push(result[i].CategoryName);
                }


                //存放各個marker
                var markers = [];
                var addMarker;

                const popup = L.popup();
                // show xy when mouse clicks
                function onMapClick(showxy) {
                    let lat = showxy.latlng.lat; // 緯度
                    let lng = showxy.latlng.lng; // 經度
                    popup
                        .setLatLng(showxy.latlng)
                        .setContent(`X座標：${lng}<br/>Y座標：${lat}`)
                        .openOn(map);
                    addmarker = new L.marker(showxy.latlng, {
                        draggable: true
                    });
                    map.addLayer(addmarker);
                    console.log(addmarker);
                    map.removeLayer(addmarker);
                }
                map.on('click', onMapClick);

                function createMarker(x, y, url, name, time, price, address, tel, blog_url) //343
                {
                    // console.log(time);
                    var str = time.split(',');
                    var timeString = '';
                    for (let i = 0; i < str.length; i++) {
                        timeString += "<br/>" + str[i];
                    }
                    var loc = L.latLng([y, x]); // [y,x]


                    if (url != "") {
                        var marker = L.marker(loc, {
                            icon: myIcon
                        }).addTo(map).bindPopup("<b><center><h2><font color='#8b0000'>" + name + "</font></h2></center></b>" +
                            "<h6><img src='../src/" + url + "' width='350px'>" +
                            "<br>營業時間:" + timeString +
                            "<br>價錢:" + price +
                            "<br>地址:" + address +
                            "<br>電話:" + tel +
                            "<br><a href=' https://www.google.com.tw/maps/search/%22" + name + "' target='_blank'><input type='button' value='GoogleMap' /></a>" +
                            "<a href='" + blog_url + "' target='_blank'><input type='button' value='詳細資訊' /></a><br/></h6>", {
                                minWidth: 400,
                                maxHeight: 500
                            });

                    } else {
                        var marker = L.marker(loc, {
                            icon: myIcon
                        }).addTo(map).bindPopup("<b><h2><center><font color='#8b0000'>" + name + "</font></center></h2></b>" +
                            "<h5><br>營業時間:" + timeString +
                            "<br>價錢:" + price +
                            "<br>地址:" + address +
                            "<br>電話:" + tel +
                            "<br><a href=' https://www.google.com.tw/maps/search/%22" + name + "' target='_blank'><input type='button'  value='GoogleMap' /></a>" +
                            "<a href='" + blog_url + "' target='_blank'><input type='button'  value='詳細資訊' /></a><br/></h5>", {
                                minWidth: 500,
                                maxHeight: 500
                            });
                        // console.log(timeString);
                    }
                    marker.on('mouseover', function(e) {
                        this.openPopup();
                    });
                    return marker;
                }

                function $(id) {
                    return document.getElementById(id);
                }
            })

        $("button.btn").click(function() {
            $("div.modify").toggleClass("active");
            $(".fa-chevron-right").toggleClass("rotate");
        });
    });
</script>

</html>