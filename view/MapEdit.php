<?php
session_start();
if (!isset($_SESSION['userLogin'])) {
    header('Location: ' . "../view/LoginPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>編輯頁面</title>
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
            top: 30px;
            left: 3vw;
            width: 55vw;
            height: 38vw;
        }

        #map {
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        .modify {
            width: 1150px;
            height: 87%;
            background-color: rgba(255, 255, 255, 0.801);
            box-shadow: 0px 0px 3px hsla(240, 40%, 15%, 0.6);
            position: fixed;
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
            transform: translateX(1145px);
        }

        .btn {
            position: absolute;
            top: 50%;
            right: 1150px;
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
    </style>
</head>

<body>
    <nav class="navbar navbar-light " style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: #005AB5;font-weight:bold">Pulifood map</a>
            <a class="d-flex" href="/controller/logout.php"><i class="fas fa-user fa-2x"></i></a>
        </div>
    </nav>
    <div class="modify">
        <button class="btn"><i class="fas fa-chevron-right fa-2x"></i></button>
        <div>
            <form action="/controller/create_restaurant_info.php" method="post" enctype="multipart/form-data">
                <!-- <table border="1" width="480" align = "center" style="background-color:white">
                <tr>
                    <th>名稱</th>
                    <th>電話</th>
                    <th>簡介</th>
                    <th>營業時間</th>
                    <th>照片</th>
                    <th>評價</th>
                    <th>價錢</th>
                    <th>地址</th>
                    <th>x座標</th>
                    <th>y座標</th>
                    <th>部落格網址</th>
                    <th>食物類別</th>
                </tr>
            <tr>
            <td><input type="text" name="RestaurantName"  required size="4" style="border-style:none" /></td>
            <td><input type="tel" name="RestaurantTEL" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantIntro" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantTime" required size="4" style="border-style:none"/></td>
            <td><input type="file" accept="image/*" multiple name="RestaurantPhoto"  size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantComment" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantPrice" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantAddress" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantX" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantY" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="BlogURL" required size="20" placeholder="請先縮短網址" style="border-style:none"/></td>
            <td id="typeSelect"></td>
            </tr>
            </table> -->


            </form>
        </div>
        <div id='map_container'>
            <div id='map'></div>
        </div>
    </div>
    <input type="submit" class="add_btn" onclick= "location.href='MapCreate.php'" value="新增餐廳" />
    <div id="list">
    </div>

    <div id="dialog">
        <h5 style="text-align: center;color:#005AB5;font-weight:bold">修改頁面</h5>
        <div id="dialog_content">

        </div>
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
    var categoryList = ["冰品", "小吃", "點心", "早餐", "東南亞", "早午餐", "美式", "韓式", "日式", "港式", "宵夜", "甜點","原住民料理"];

    window.onload = function() {
        setDialog();

        window.onresize = setDialog;
    }

    function setDialog() {
        var w = document.documentElement.clientWidth;
        var h = document.documentElement.clientHeight;

        document.getElementById("dialog").style.left = (w - 500) / 2 + "px";
        document.getElementById("dialog").style.top = (h - 500) / 2 + "px";
    }

    function updateBtn(pos) {
        var dialog = document.getElementById("dialog");
        var content = document.getElementById("dialog_content");

        dialog.style.display = "block";

        var tbl = "<form action=\"/controller/update_restaurant_info.php\" method=\"post\" enctype=\"multipart/form-data\">";

        tbl += "名稱: <input type=\"text\" name=\"RestaurantName\" size=\"10\" style=\"border:2px #9bd4e9 solid\" value=\"" + restaurant_name[pos] + "\" /><br/>";
        tbl += "電話: <input type=\"tel\" name=\"RestaurantTEL\" size=\"10\" style=\"border:2px #9bd4e9 solid\" value=\"" + tel[pos] + "\" /><br/>";

        if (photo[pos] != "") {
            //tbl += "<label for=\"files\" class=\"btn btn-primary\">選取檔案</label>";
            //tbl += "<label for=\"files\" class=\"edit_btn\">更改檔案 </label>";
            tbl += "照片:<input type=\"file\" id=\"files\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"visibility:hidden\" value=\"" + photo[pos] + "\">&emsp;&emsp;<span style=\"margin-left: -320px;\"> 您已上傳的檔案->" + photo[pos] + "</span><br/>";
            tbl += "<input class=\"form-control\" type=\"file\" id=\"formFileMultiple\" multiple name=\"RestaurantPhoto\">";
            // tbl += "<label for=\"input-25\">Planets and Satellites</label>";
            // tbl += "<div class=\"file-loading\"><input id=\"input-25\" name=\"RestaurantPhoto\" type=\"file\" multiple></div>";



        } else {
            // tbl += "照片: <input type=\"file\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"border-style:none\" value=\""+ photo[pos] +"\" /><br/>";
            // tbl += "照片:<br/><input type=\"file\" id=\"files\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"visibility:hidden\" value=\""+ photo[pos] +"\"><span style=\"margin-left: -320px;\"> 您已上傳的檔案:" + photo[pos] + "</span><br/>";
            tbl += "照片: <input class=\"form-control\" type=\"file\" id=\"formFileMultiple\" multiple name=\"RestaurantPhoto\">";
        }


        tbl += "營業時間:<br/><textarea type=\"text\" name=\"RestaurantTime\" cols=\"40\" rows=\"3\" style=\"border:2px #9bd4e9 solid\">"+ time[pos] + "</textarea><br/>";
        tbl += "價錢: <input type=\"text\" name=\"RestaurantPrice\" size=\"10\" style=\"border:2px #9bd4e9 solid\" value=\"" + price[pos] + "\"/><br/>";
        tbl += "地址: <input type=\"text\" name=\"RestaurantAddress\" size=\"30\" style=\"border:2px #9bd4e9 solid\" value=\"" + address[pos] + "\" /><br/>";
        tbl += "x座標: <input type=\"text\" name=\"RestaurantX\" size=\"4\" style=\"border:2px #9bd4e9 solid\" value=\"" + x[pos] + "\" /><br/>";
        tbl += "y座標: <input type=\"text\" name=\"RestaurantY\" size=\"4\" style=\"border:2px #9bd4e9 solid\" value=\"" + y[pos] + "\" /><br/>";
        tbl += "部落格網址: <input type=\"text\" name=\"BlogURL\" size=\"30\" style=\"border:2px #9bd4e9 solid\" value=\"" + blog_url[pos] + "\" /><br/>";
        tbl += "食物類型: " + categoryTbl(category[pos]) + "<br />";

        tbl += "<input type=\"hidden\" name=\"RestaurantID\" value=\"" + id[pos] + "\">";
        tbl += "<input type=\"submit\" class=\"edit_btn\" value=\"更新\" style=\"padding=10px;\"></form>";
        tbl += "<td><button id='closeBtn' onclick='closeClick()'>關閉</button></td>";
        content.innerHTML = tbl;
    }

    function closeClick() {
        document.getElementById("dialog").style.display = "none";
    }

    function categoryTbl(curType) {
        let str = "<select id=\"type\" name=\"CategoryName[]\" multiple size='3' style=\"border:8px #9bd4e9 solid\">";
        for (let i = 0; i < categoryList.length; i++) {
            if (categoryList[i] == curType) {
                str += `<option value=\"${categoryList[i]}\" selected>${categoryList[i]}</option>`;
            } else {
                str += `<option value=\"${categoryList[i]}\">${categoryList[i]}</option>`;
            }
        }
        str += "</select>";
        // if(curType == "")
        // {
        //     document.getElementById("typeSelect").innerHTML = str;
        // }
        return str;
    }

    $(function() {
        // categoryTbl("");
        //存放各個marker的資訊，到時候從DB取出時可直接存成陣列
        // var x = [160,656,333,1003,786];
        // var y = [195,398,573,398,471];
        // var name = ["暨大管理學院","肯德基","日式拉麵店","雞排店","飲料店"];
        // var url = ["暨南cm.jpg","","","",""];
        fetch("/controller/get_all_restaurant_info.php")
            .then(res => {
                return res.json()
            })
            .then(result => {
                const bounds = [[0,0], [750,1000]];
                const bounds2 = [[-250,-250], [1200,1250]];
                const map = L.map('map', {
                    minZoom: 0,
                    zoom:0,
                    maxZoom: 2,
                    maxBounds: bounds2,
                    crs: L.CRS.Simple
                });
                map.setView([365, 800]);
                map.fitBounds(bounds);
                const image = L.imageOverlay('../src/puliMap3.png', bounds).addTo(map);

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
                    time.push((result[i].RestaurantTime).toString());
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

                var tbl = "<table class='data'>";
                tbl += "<tr><th>名稱</th><th>x座標</th><th>y座標</th><th>類別</th><th>營業時間</th><th>照片</th><th>電話</th><th>價錢</th><th>地址</th><th style='width:50px'>wordpress</th><th colspan='2'></th></tr>";

                tbl += "<tbody>";
                for (let i = 0; i < x.length; i++) {
                    markers.push(createMarker(x[i], y[i], photo[i], restaurant_name[i], time[i], price[i], address[i], tel[i], blog_url[i]));

                    // $("list").innerHTML += "<tr><td>"+ restaurant_name[i]+"</td>";
                    // $("list").innerHTML += "<td>" + restaurant_name[i] +"</td>";
                    // $("list").innerHTML += "<td>(" + x[i] +"," + y[i] +")</td>";
                    // $("list").innerHTML += "<td>" + time[i] +"</td>";
                    // $("list").innerHTML += "<td>" + tel[i] +"</td>";
                    // $("list").innerHTML += "<td>" + cmt[i] +"</td>";
                    // $("list").innerHTML += "<td>" + photo[i] +"</td>";
                    // $("list").innerHTML += "<td>" + intro[i] +"</td>";
                    // $("list").innerHTML += "</tr>";
                    var str = time[i].split(',');
                    var timeString = '';
                    for (let j = 0; j < str.length; j++) {
                        timeString += str[j] + "<br/>";
                    }


                    tbl += "<tr>";
                    tbl += "<td>" + restaurant_name[i] + "</td>";
                    tbl += "<td>" + x[i] + "</td>";
                    tbl += "<td>" + y[i] + "</td>";
                    tbl += "<td>" + category[i] + "</td>";
                    tbl += "<td>" + timeString + "</td>";
                    tbl += "<td>" + photo[i] + "</td>";
                    tbl += "<td>" + tel[i] + "</td>";
                    tbl += "<td>" + price[i] + "</td>";
                    tbl += "<td>" + address[i] + "</td>";
                    tbl += "<td>" + blog_url[i] + "</td>";

                    //修改按鈕
                    tbl += "<td><button onclick=\"updateBtn('" + i + "')\" class=\"edit_btn\">修改</button></td>";

                    //刪除按鈕
                    //tbl += "<td><a href=\"delete.php?del="+ id[i] +"\" class='del_btn'>刪除</a></td>";
                    tbl += "<td><a type=\"submit\" class='del_btn ' href='/controller/delete_restaurant_info.php?rid=" + id[i] + "'>刪除</a></td>";
                    tbl += "</tr>";
                }

                tbl += "</tbody></table>";

                $("list").innerHTML = tbl;

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
                    y = parseInt(y)+7;
                    var loc = L.latLng([y, x]); // [y,x]


                    if (url != "") {
                        var marker = L.marker(loc, {
                            icon: myIcon
                        }).addTo(map).bindPopup("<b><center><h2><font color='#8b0000'>" + name + "</font></h2></center></b>" +
                            "<h6><img src='/" + url + "' width='200px'>" +
                            "<br>營業時間:" + timeString +
                            "<br>價錢:" + price +
                            "<br>地址:" + address +
                            "<br>電話:" + tel +
                            "<br><a href=' https://www.google.com.tw/maps/search/%22" + name + "' target='_blank'><input type='button' value='GoogleMap' /></a>" +
                            "<a href='" + blog_url + "' target='_blank'><input type='button' value='詳細資訊' /></a><br/></h6>", {
                                minWidth: 400,
                                maxHeight: 300
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
                                maxHeight: 300
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