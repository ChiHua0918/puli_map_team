<?php
    session_start(); 
    if(!isset($_SESSION['userLogin'])){
        header('Location: '."/view/LoginPage.php");
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>

    <style>
        html, body {
            height: 100vh;
            padding-bottom:100px;
        }
        #map_container {
            position: relative;
            z-index: 1;
            top: 100px;
            left: 6vw;
            width: 88vw;
            height: 90%;
        }
        #map {
            z-index: 1;
            width: 100%;
            height: 100%;
        }
        .modify{
            width: 1200px;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.801);
            box-shadow: 0px 0px 3px hsla(240, 40%, 15%, 0.6);
            position: absolute;
            z-index: 2;
            right:0%;
            text-align: center;
            transform: translateX(0);
            transition: all 0.5s;
        }
        ul{
            list-style-type:none ;
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
        input[type=submit],button {
            font-family: times new roman;
            font-size:14pt;
            vertical-align:middle;
        }
        select, button {
            vertical-align:middle;
            font-size: 14pt;
            font-family: times new roman;
        }
        #data {
            text-align: left;
            display:inline-block;
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
        .thead {
        }
        .tbody {
            
        }
        tr {
            border-bottom: 1px solid #cbcbcb;
        }
        th, td{
            height: 40px;
            padding: 2px;
        }
        tr:hover {
            background-color: rgba(235, 235, 235, 0.5);
        }
        .edit_btn {
            text-decoration: none;
            padding: 3px 6px;
            background: #2E8B57;
            color: white;
            border-radius: 3px;
        }
        .del_btn {
            width: 4em;
            text-decoration: none;
            padding: 3px 6px;
            color: white;
            border-radius: 3px;
            background: #800000;
        }
        #dialog{
            display: none;
            width: 500px;
            height: 500px;
            position: absolute;
            padding: 30px;
            /* border: 2px solid blue; */
            background-color: rgba(155, 212, 233, 0.9);
            z-index: 3;
            /* right: 35%;
            top: 15%; */
        }
        #closeBtn{
            /* position:relative; */
            margin: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light " style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand">foodmap</a>
            <a class="d-flex" href="/controller/logout.php"><i class="fas fa-user fa-2x"></i></a>
        </div>
    </nav>
    <div class="modify">
        <button class="btn"><i class="fas fa-chevron-right fa-2x"></i></button>
        <div>
            <h1 align = "center">資料總表</h1>
            <form action="/controller/create_restaurant_info.php" method="post" enctype="multipart/form-data">
            <table border="1" width="480" align = "center" style="background-color:white">
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
            </tr>

            </table>

            <input type="submit" value="新增餐廳"/>

            </form>
        </div>
        
        <div id="list">
        </div>
    </div>
    <div id='map_container'>
        <div id='map'></div>
    </div>

    <div id="dialog">
        <h5 style="text-align: center;">修改頁面</h5>
        <div id="dialog_content">

        </div>
        <button id="closeBtn" onclick="closeClick()">關閉</button>
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
    var x =[];
    var y = [];
    var time = [];
    var tel = [];
    var cmt = [];
    var photo = [];
    var intro = [];
    var restaurant_name = [];
    var price = [];
    var address = [];

    window.onload = function()
    {
        setDialog();

        window.onresize = setDialog;
    }
    function setDialog()
    {
        var w=document.documentElement.clientWidth;
        var h=document.documentElement.clientHeight;

        document.getElementById("dialog").style.left = (w-500)/2+"px";
        document.getElementById("dialog").style.top = (h-500)/2+"px";
    }
    function updateBtn(pos)
    {
        var dialog = document.getElementById("dialog");
        var content = document.getElementById("dialog_content");

        dialog.style.display = "block";
        
        var tbl = "<form action=\"/controller/update_restaurant_info.php\" method=\"post\" enctype=\"multipart/form-data\">";

        tbl += "名稱: <input type=\"text\" name=\"RestaurantName\" size=\"10\" style=\"border-style:none\" value=\""+ restaurant_name[pos] +"\" /><br/>";
        tbl += "電話: <input type=\"tel\" name=\"RestaurantTEL\" size=\"10\" style=\"border-style:none\" value=\""+ tel[pos] +"\" /><br/>";
        tbl += "簡介: <textarea type=\"text\" name=\"RestaurantIntro\" size=\"30\" style=\"border-style:none\" >"+ intro[pos] + "</textarea><br/>";
        
        if(photo[pos] != "")
        {
            //tbl += "<label for=\"files\" class=\"btn btn-primary\">選取檔案</label>";
            //tbl += "<label for=\"files\" class=\"edit_btn\">更改檔案 </label>";
            tbl += "照片:<br/><input type=\"file\" id=\"files\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"visibility:hidden\" value=\""+ photo[pos] +"\"><span style=\"margin-left: -320px;\"> 您已上傳的檔案:" + photo[pos] + "</span><br/>";
            tbl += "<input class=\"form-control\" type=\"file\" id=\"formFileMultiple\" multiple name=\"RestaurantPhoto\">";
            // tbl += "<label for=\"input-25\">Planets and Satellites</label>";
            // tbl += "<div class=\"file-loading\"><input id=\"input-25\" name=\"RestaurantPhoto\" type=\"file\" multiple></div>";

            
            
        }
        else
        {
            // tbl += "照片: <input type=\"file\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"border-style:none\" value=\""+ photo[pos] +"\" /><br/>";
            // tbl += "照片:<br/><input type=\"file\" id=\"files\" accept=\"image/*\" multiple name=\"RestaurantPhoto\" size=\"10\" style=\"visibility:hidden\" value=\""+ photo[pos] +"\"><span style=\"margin-left: -320px;\"> 您已上傳的檔案:" + photo[pos] + "</span><br/>";
            tbl += "照片: <input class=\"form-control\" type=\"file\" id=\"formFileMultiple\" multiple name=\"RestaurantPhoto\">";
        }
        
        
        tbl += "營業時間: <input type=\"text\" name=\"RestaurantTime\" size=\"10\" style=\"border-style:none\" value=\""+ time[pos] +"\" /><br/>";
        tbl += "評價: <input type=\"text\" name=\"RestaurantComment\" size=\"10\" style=\"border-style:none\" value=\""+ cmt[pos] +"\" /><br/>";
        tbl += "價錢: <input type=\"text\" name=\"RestaurantPrice\" size=\"10\" style=\"border-style:none\" value=\""+ price[pos] +"\"/><br/>";
        tbl += "地址: <input type=\"text\" name=\"RestaurantAddress\" size=\"30\" style=\"border-style:none\" value=\""+ address[pos] +"\" /><br/>";
        tbl += "x座標: <input type=\"text\" name=\"RestaurantX\" size=\"4\" style=\"border-style:none\" value=\""+ x[pos] +"\" /><br/>";
        tbl += "y座標: <input type=\"text\" name=\"RestaurantY\" size=\"4\" style=\"border-style:none\" value=\""+ y[pos] +"\" /><br/>";
        
        tbl += "<input type=\"hidden\" name=\"RestaurantID\" value=\""+id[pos]+"\">";
        tbl += "<input type=\"submit\" class=\"edit_btn\" value=\"更新\" style=\"padding=10px;\"></form>"
    
        content.innerHTML = tbl;
    }
    function closeClick()
    {
        document.getElementById("dialog").style.display = "none";
    }

    $(function () {
        //存放各個marker的資訊，到時候從DB取出時可直接存成陣列
        // var x = [160,656,333,1003,786];
        // var y = [195,398,573,398,471];
        // var name = ["暨大管理學院","肯德基","日式拉麵店","雞排店","飲料店"];
        // var url = ["暨南cm.jpg","","","",""];
        fetch("/controller/get_all_restaurant_info.php")
        .then(res => {  return res.json()})
        .then(result => { 
            const bounds = [[0,0], [730,1600]];
            const map = L.map('map', {
                crs: L.CRS.Simple
            });
            map.setView([365, 800]);
            map.fitBounds(bounds);
            const image = L.imageOverlay('/src/puliMap2.png', bounds).addTo(map);
            
            // set my own marker icon
            const myIcon = L.icon({
                iconUrl: '/src/markericon2.png',
                iconSize: [34, 48],
            });

            console.log(result);
        
            for(let i = 0 ; i<result.length ; i++)
            {
                id.push(result[i].RestaurantID);
                x.push(result[i].RestaurantX);
                y.push(result[i].RestaurantY);
                time.push(result[i].RestaurantTime);
                tel.push(result[i].RestaurantTEL);
                cmt.push(result[i].RestaurantComment);
                photo.push(result[i].RestaurantPhoto);
                intro.push(result[i].RestaurantIntro);
                restaurant_name.push(result[i].RestaurantName);
                price.push(result[i].RestaurantPrice);
                address.push(result[i].RestaurantAddress);
            }


            //存放各個marker
            var markers = []; 
            var addMarker;

            var tbl = "<table class='data'>";
            tbl += "<tr><th>名稱</th><th>x座標</th><th>y座標</th><th>簡介</th><th>營業時間</th><th>照片</th><th>電話</th><th>評價</th><th>價錢</th><th>地址</th><th colspan='2'></th></tr>";

            tbl += "<tbody>";
            for(let i = 0 ; i < x.length ; i++)
            {
                markers.push(createMarker(x[i],y[i],photo[i],restaurant_name[i]));

                // $("list").innerHTML += "<tr><td>"+ restaurant_name[i]+"</td>";
                // $("list").innerHTML += "<td>" + restaurant_name[i] +"</td>";
                // $("list").innerHTML += "<td>(" + x[i] +"," + y[i] +")</td>";
                // $("list").innerHTML += "<td>" + time[i] +"</td>";
                // $("list").innerHTML += "<td>" + tel[i] +"</td>";
                // $("list").innerHTML += "<td>" + cmt[i] +"</td>";
                // $("list").innerHTML += "<td>" + photo[i] +"</td>";
                // $("list").innerHTML += "<td>" + intro[i] +"</td>";
                // $("list").innerHTML += "</tr>";

                

                tbl += "<tr>";
                tbl += "<td>" + restaurant_name[i] +"</td>";
                tbl += "<td>" + x[i] + "</td>";
                tbl += "<td>" + y[i] + "</td>";
                tbl += "<td>" + intro[i] + "</td>";
                tbl += "<td>" + time[i] +"</td>";
                tbl += "<td>" + photo[i] +"</td>";
                tbl += "<td>" + tel[i] +"</td>";
                tbl += "<td>" + cmt[i] +"</td>";
                tbl += "<td>" + price[i] +"</td>";
                tbl += "<td>" + address[i] + "</td>";

                //修改按鈕
                tbl += "<td><button onclick=\"updateBtn('" + i + "')\" class=\"edit_btn\">修改</button></td>";

                //刪除按鈕
                //tbl += "<td><a href=\"delete.php?del="+ id[i] +"\" class='del_btn'>刪除</a></td>";
                tbl +="<td><a class='del_btn ' href='/controller/delete_restaurant_info.php?rid="+id[i]+"'>刪除</a></td>";
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
                    addmarker = new L.marker(showxy.latlng, {draggable:true});
                    map.addLayer(addmarker);
                    console.log(addmarker);
                    map.removeLayer(addmarker);
            }
            map.on('click', onMapClick);

            function createMarker( x ,  y , url , name)
            {
                var loc = L.latLng([y, x]); // [y,x]
                
                if(url != "")
                {
                    var marker = L.marker(loc,{icon: myIcon}).addTo(map).bindPopup("<b>" + name + "</b><br><img src=' " + url +"' width='150px' alt='ncnu cm'><br/><a target='_blank' href='https://cm.ncnu.edu.tw/'>click for more info</a>");
                }
                else
                {
                    var marker= L.marker(loc,{icon: myIcon}).addTo(map).bindPopup("<b>"+ name + "</b><br>");
                }
                marker.on('mouseover', function (e) {
                    this.openPopup();
                });
                return marker;
            }

            function $(id)
            {
                return document.getElementById(id);
            }
        })

        $("button.btn").click(function () {
            $("div.modify").toggleClass("active");
            $(".fa-chevron-right").toggleClass("rotate");
        });
    });
</script>

</html>