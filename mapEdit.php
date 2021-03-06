<?php 
header("Content-Type:text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>編輯頁面</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://kit.fontawesome.com/99bbad7d3f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    
    <!-- bootstrap 5.x and 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
<!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you 
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
   3.3.x versions without popper.min.js. -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
    dialog. Bootstrap 5.x and 4.x is supported. You can also use the 3.3.x versions. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/themes/fa/theme.js"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below (replace LANG.js with your locale file) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/locales/LANG.js"></script>

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
            width: 1300px;
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
        body {
            background-image: url("/PuliMap/食物背景透明3.png");
            background-size: 100%;
        }
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
            transform: translateX(1295px);
        }
        .btn {
            position: absolute;
            top: 50%;
            right: 1300px;
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
            /* position: absolute; */
            position: fixed;
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
        #closeBtn{
            /* position:relative; */
            margin: 15px;
        }
    </style>
</head>
<script>


</script>
<body>
    <div class="modify">
    <button class="btn"><i class="fas fa-chevron-right fa-2x"></i></button>
        <div>
            <h1 align = "center">資料總表</h1>
            <form action="/PuliMap/api/create.php" method="post">
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
                    <th>Wordpress網址</th>
                    <th>食物類別</th>
                </tr>
            <tr>
            <td><input type="text" name="RestaurantName"  required size="4" style="border-style:none" /></td>
            <td><input type="tel" name="RestaurantTEL" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantIntro" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantTime" required size="35" placeholder="星期五 13:00~14:00,星期六 13:00~14:00" style="border-style:none"/></td>
            <td><input type="file" accept="image/*" multiple name="RestaurantPhoto"  size="4" style="border-style:none; width:150px"/></td>
            <td><input type="text" name="RestaurantComment" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantPrice" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantAddress" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantX" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="RestaurantY" required size="4" style="border-style:none"/></td>
            <td><input type="text" name="wordpressLink" required size="20" placeholder="請先縮短網址" style="border-style:none"/></td>
            <!-- <td><select id="type" name="CategoryName">
                <option value="麵">麵</option>
                <option value="你好">你好</option>
                <option value="觀光夜市">觀光夜市</option>
                <option value="漢堡舖子">漢堡舖子</option>
                </select></td> -->
            <td id="typeSelect"></td>
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
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://kit.fontawesome.com/99bbad7d3f.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
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
    var wordpress = [];
    var category = [];

    var categoryList = ["冰品","小吃","點心","早餐","東南亞","早午餐","美式","韓式","日式","港式","宵夜","甜點"];

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

        
        var tbl = "<form action=\"/PuliMap/api/update.php\" method=\"post\">";

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
        tbl += "Wordpress網址: <input type=\"text\" name=\"wordpressLink\" size=\"20\" style=\"border-style:none\" value=\""+ wordpress[pos] +"\" /><br/>";
        
        // let categoryStr = ;

        tbl += "食物類型:" + categoryTbl(category[pos]) +  "<br />";   


        tbl += "<input type=\"hidden\" name=\"RestaurantID\" value=\""+id[pos]+"\">";
        tbl += "<input type=\"submit\" class=\"edit_btn\" value=\"更新\" style=\"padding=10px;\"></form>"

        content.innerHTML = tbl;
    }

    function closeClick()
    {
        document.getElementById("dialog").style.display = "none";
    }
    function categoryTbl(curType)
    {
        let str = "<select id=\"type\" name=\"CategoryName\">";
        for(let i = 0 ; i<categoryList.length ; i++)
        {
            if( categoryList[i] == curType)
            {
                str += `<option value=\"${categoryList[i]}\" selected>${categoryList[i]}</option>`;
            }
            else
            {
                str += `<option value=\"${categoryList[i]}\">${categoryList[i]}</option>`;

            }
        }
        str += "</select>";
        if(curType == "")
        {
            document.getElementById("typeSelect").innerHTML = str;
        }
        return str;
    }

    $(function () {

        categoryTbl("");
        //存放各個marker的資訊，到時候從DB取出時可直接存成陣列
        // var x = [160,656,333,1003,786];
        // var y = [195,398,573,398,471];
        // var name = ["暨大管理學院","肯德基","日式拉麵店","雞排店","飲料店"];
        // var url = ["暨南cm.jpg","","","",""];
<<<<<<< HEAD
        fetch("/PuliMap/api/read_all.php")
=======
        fetch("/PuliMap/api/read.php")
>>>>>>> ef28863a89116fcbc449e73840cfc6d1431eecc9
        .then(res => {  return res.json()})
        .then(result => { 
            console.log(result)
            const bounds = [[0,0], [730,1600]];
            const map = L.map('map', {
                crs: L.CRS.Simple
            });
            map.setView([365, 800]);
            map.fitBounds(bounds);
            const image = L.imageOverlay('/PuliMap/puliMap2.png', bounds).addTo(map);
            
            // set my own marker icon
            const myIcon = L.icon({
                iconUrl: '/PuliMap/markericon2.png',
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
                wordpress.push(result[i].wordpressLink);
                category.push(result[i].CategoryName);
            }


            //存放各個marker
            var markers = []; 
            var addMarker;

            var tbl = "<table class='data'>";
            tbl += "<tr><th>名稱</th><th>x座標</th><th>y座標</th><th>簡介</th><th>營業時間</th><th>照片</th><th>電話</th><th>評價</th><th>價錢</th><th>地址</th><th style='width:50px'>Wordpress</th><th>食物類別</th><th colspan='2'></th></tr>";

            tbl += "<tbody>";
            for(let i = 0 ; i < x.length ; i++)
            {
                markers.push(createMarker(x[i],y[i],photo[i],restaurant_name[i],cmt[i],wordpress[i]));

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
                tbl += "<td>" + wordpress[i] + "</td>";
                tbl += "<td>" + category[i] + "</td>";

                //修改按鈕
                tbl += "<td><button onclick=\"updateBtn('" + i + "')\" class=\"edit_btn\">修改</button></td>";

                //刪除按鈕
                //tbl += "<td><a href=\"delete.php?del="+ id[i] +"\" class='del_btn'>刪除</a></td>";
                tbl +="<td>";
                var del_form = "<form action=\"http://localhost/PuliMap/api/delete.php\" method=\"POST\">"
                del_form += "<input type=\"hidden\" name=\"RestaurantID\" value=\""+id[i]+"\">";
                tbl += del_form;
                tbl += "<input type=\"submit\" class=\"del_btn\" value=\"刪除\"></form></td>";
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

            function createMarker( x ,  y , url , name, comment, wordpressLink)
            {
                var loc = L.latLng([y, x]); // [y,x]
                
                if(url != "")
                {
                    var marker = L.marker(loc,{icon: myIcon}).addTo(map).bindPopup("<b><center>" + name + "</center></b><br><img src='/puli_map_team-MVC/src/" + url +"' width='150px' alt='ncnu cm'>"+"<br>評價:"+comment+"<br><a href=' https://www.google.com.tw/maps/search/"+name+"' target='_blank'><input type='button' value='GoogleMap' /></a>"+"<a href='"+ wordpressLink +"' target='_blank'><input style='float:right' type='button' value='詳細資訊' /></a><br/>");

                }
                else
                {
                    var marker= L.marker(loc,{icon: myIcon}).addTo(map).bindPopup("<b><center>"+ name + "</center></b>"+"<br>評價:"+comment+"<br><a href=' https://www.google.com.tw/maps/search/"+name+"' target='_blank'><input type='button' value='GoogleMap' /></a>"+"<a href='"+ wordpressLink +"' target='_blank'><input type='button' value='詳細資訊' /></a><br/>");
                }
                marker.on('mouseover', function (e) {
                    this.openPopup();
                });
                return marker;
            }

            function randomSelected()
            {
                for(let i = 0 ; i<markers.length ; i++)
                {
                    map.addLayer(markers[i]);
                    //console.log(markers[i]);
                    
                }
                //console.log("-------------------");
                
                var index = Math.floor(Math.random()*(markers.length)); // random * (max - min ) + min
                //console.log("Random selected marker: ",index);
                for(let i = 0 ; i<markers.length ; i++)
                {
                    if(markers[i] != markers[index])
                    {
                        //console.log(markers[i]);
                        map.removeLayer(markers[i]);
                    }
                }
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