<!DOCTYPE html>
<html lang="en">
<head>
    <title>地圖頁面</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://kit.fontawesome.com/99bbad7d3f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <style>
        html, body {
        height: 100%;
        }
        #map {
        z-index: 1;
        width: 100%;
        height: 100%;
        }
    </style>
    <style type="text/css">
        .menu{
            width: 300px;
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
        #main {
            text-align: left;
            display:inline-block;
            line-height: 30pt;
        }
        .button {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding: 6px 20px;
            border: 0px solid #ae7a0d;
            border-radius: 23px;
            background: #ffc815;
            background: -webkit-gradient(linear, left top, left bottom, from(#ffc815), to(#ae7a0d));
            background: -moz-linear-gradient(top, #ffc815, #ae7a0d);
            background: linear-gradient(to bottom, #ffc815, #ae7a0d);
            text-shadow: #7c5709 2px 2px 0px;
            font: normal normal bold 20px arial;
            color: #ffffff;
            text-decoration: none;
        }
        .button:hover {
            border: 0px solid #f8ae12;
            background: #fff019;
            background: -webkit-gradient(linear, left top, left bottom, from(#fff019), to(#d19210));
            background: -moz-linear-gradient(top, #fff019, #d19210);
            background: linear-gradient(to bottom, #fff019, #d19210);
            color: #ffffff;
            text-decoration: none;
        }
        .button:active {
            background: #ae7a0d;
            background: -webkit-gradient(linear, left top, left bottom, from(#ae7a0d), to(#ae7a0d));
            background: -moz-linear-gradient(top, #ae7a0d, #ae7a0d);
            background: linear-gradient(to bottom, #ae7a0d, #ae7a0d);
        }
        .button:before{
            content:  "\0000a0";
            display: inline-block;
            height: 24px;
            width: 24px;
            line-height: 24px;
            margin: 0 4px -6px -4px;
            position: relative;
            top: 0px;
            left: 0px;
            background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE9klEQVRIiY1UW09cVRT+1j6XOTMMMFwHaAsEKEMLRWlrbUyqtdo2tk0ajUlfDA8khKfa2MQYf4P60r5Jy0tfvWDrg9dojFFTI2jFoWBLK3IdrsMw5wzn7LOXLzNkClPqTk7Ot9dZ51t7f+sCbF+igG0nnx0xFfq7t7cnBOA4M1qIuIQZU0Q0woyRa9cGXAAqj2RHTFs+oLe3p4WZ3z19+pVTjY2NlYFAwFpZWVkdHY0n4vH4V45jv93fP5DJO63aCT9yg0uXLp5rbW29euz4y41aJIoHCyksrm9gV1kR6iMWFv4Zw63BTwaXV5Yv9vcPzPyfAFrWwL29PZHq6uiN02fPx5aoGNOrNoKmDk0IjM8ncWcmidqaWtRXFO2emppKdnTs/3VoaNjLknH22Ybz5Tlz4EBnh21GYHs+SoImVmwXs2sO0q7CiuPhy7EE9rTsCzc1NZ1lRl3e5R+baD2ru2Dm801tHWIq7cKVCjPJNNYcDynXh+1J+BAACOMpQjQaPUiEOgATT0q0ntsIISo1w0JiyUFGMpYdD47HkMzQdQMhXYOpETwmmIZpCSFCW3RXhXAugGLm9YxjY0MCM8kMbAmQIFimjuKgiaCpI2gIRCwDSc9TSik3Twr1OCwAoL9/QAH49uHYCKLFAaw6HjylYBo6ioMBlBcFUF1sYXckhKgpMTszE2dG4kn6bzUMjv7151yln0RrTSkMTYNlaAgFdJQGTZSHTDSUhbA0OS7v37/3DYCpLRIVxFqOfWhoOLm/fV9KbTjHnm7aZVVUVsJVgKlpqCu10FwegjP3AJ/f/HQ9WlV9I7a39fZnt27llyYK4VyjCQDo7e0BgMMA3nnxhRPPx9pikaJwWJ+fm7N/Hx5OxEfjU411tUfU2sTyfuuuqTKrH0rPe+/C1clVPGZtGxXZQOUAn2CmRoBDRLQM4M7szGz8WLN5oy0qT+3dExGL05NrS0vzH7iuc+XClX/XUKBc9TzeTe36+wdWAXyEAnX9xpv1i3VVR0TDwVMoCv5QwuC3FhfmMgDe38KDXA4YjyYmX8dt2r7+bOloamm6E77c09B1koIGLNdJnzzXaay+ejgc//h2Mle+BAC5WaTyybq7u0VLSwt1dHRQU1OT1t7eLmKxmIjFYnrCr07WGst3UwsP2w3T3F3T3IWgSVhPLh+20+tr556pGKnofM0bHh5WAFjLRmIAoq+vj7q6ujTbtjWllAnA0jQtSERFuq4Xa5pW4rJZfD9dvR4Q3jhWx17STbOoru05aHItNL+QfGpizv5+2quZP3r0KB06dAibEl2+fBnz8/O653lBKWVYCFEOoJqIaoioAUAjETUz814FapnJlFmOizGV+KOZ/EzpulWPL777hSbXrK83jKoFKSXZtq30nEREJHzfF9nEW8wcBhAGEAEQye2JKAzAYGZvIl1l6+QPpn7+6czfiR/Dy2ncRHhXAoCllJJKqc1ZBGaGpmlKCCGVUhkiWmfmXOIlEdlZm5U9hGTS7HvpmoklW/xmy7R0iyvvST2SgFIZIYRkZvVIo/X19cH3fZFKpYSUUicinZl1ALoQQmdmXQghlFKCiBQzKyKSSimZPYRkZmkYhgyHw4qIVMFG6+7uFul0GkIIOI4jDMOAUgrMLAKBwKZfJpOBEEIJIeC6LkKhkPJ9H2VlZbh+/fomp8h7iwK2Qn6F/Avi/wDP6ltgUE9BOwAAAABJRU5ErkJggg==") no-repeat left center transparent;
            background-size: 100% 100%;
        }
        .active {
            transform: translateX(295px);
        }
        .btn {
            position: absolute;
            top: 50%;
            right: 300px;
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
    </style>
    <script>
        $(function () {
            $("button.btn").click(function () {
                $("div.menu").toggleClass("active");
                $(".fa-chevron-right").toggleClass("rotate");
            });
        });

        
    </script>
</head>
<body>
    <div class="menu"><br/>
        <button class="btn"><i class="fas fa-chevron-right fa-2x"></i></button>
        <a class="button" href="#" onclick="randomSelected()">隨機選取餐廳</a><hr />
        <div id="main">
            時段: <select name="time">
            <option>7~10點</option>
            <option>10~14點</option>
            <option>14~17點</option>
            <option>17~20點</option>
            </select><br/>
            距離: <select name="dist">
            <option><100m</option>
            <option>100~600m</option>
            <option>600m~<1km</option>
            <option>>1km</option>
            </select><br/>
            類別: 
            <select name="type">
            <option>麵食</option>
            <option>飯食</option>
            <option>日式料理</option>
            <option>韓式料理</option>
            </select>
            <br />
            價位: 
            <select name="price">
            <option><100</option>
            <option>100~150</option>
            <option>150~200</option>
            <option>>200</option>
            </select>
            <br />
            <!--
            價位: <input list="priceList" name="browser"> <br/>
            <datalist id="priceList">
            <option value="<100">
            <option value="100~150">
            <option value="150~200">
            </datalist> 
            <br />
            -->
        </div>
        <br/><br/><input type="submit" value="OK"/>
    </div>
    <div id='map'></div>
    <script>
            //存放各個marker的資訊，到時候從DB取出時可直接存成陣列
            // var x = [160,656,333,1003,786];
            // var y = [195,398,573,398,471];
            // var name = ["暨大管理學院","肯德基","日式拉麵店","雞排店","飲料店"];
            // var url = ["暨南cm.jpg","","","",""];
            fetch("/PuliMap/api/read.php")
            .then(res => {  return res.json()})
            .then(result => { 
                console.log(result);

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

                for(let i = 0 ; i<result.length ; i++)
                {
                    id.push(result[i].Restaurant_ID);
                    x.push(result[i].Restaurant_x);
                    y.push(result[i].Restaurant_y);
                    time.push(result[i].Restaurant_time);
                    tel.push(result[i].Restaurant_TEL);
                    cmt.push(result[i].Restaurant_comment);
                    photo.push(result[i].Restaurant_photo);
                    intro.push(result[i].Restaurant_intro);
                    restaurant_name.push(result[i].Restaurant_name);
                    price.push(result[i].Restaurant_price);
                    address.push(result[i].Restaurant_address);
                }
                

                //存放各個marker
                var markers = []; 
    
                const map = L.map('map', {
                    minZoom: 0,
                    maxZoom: 4,
                    maxBounds: [[0,0],[900,1600]],
                    crs: L.CRS.Simple
                });
                var addMarker;
    
                const bounds = [[0,0], [900,1600]];
                const image = L.imageOverlay('puliMap.png', bounds).addTo(map);
                map.fitBounds(bounds);
                map.setView( [450, 800],0);
    
                // set my own marker icon
                const myIcon = L.icon({
                iconUrl: 'markericon.png',
                iconSize: [34, 48],
                });
    
                //console.log(x.length);
                //console.log(y.length);

                for(let i = 0 ; i < x.length ; i++)
                {
                    markers.push(createMarker(x[i],y[i],photo[i],restaurant_name[i]));
                }
    
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
                    map.setView( [450, 600],0);
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
            })
    </script>

</body>
</html>