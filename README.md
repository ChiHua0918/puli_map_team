# puli_map_team
創建餐廳create.php
API名稱 : 創建餐廳資訊

檔名:create.php

HTTP Method:POST

功能說明:
先連接login.php 以 核對使用者權限(登入)，授權上傳餐廳資料至資料庫puli_restaurant資料表儲存。
且欄位 Restaurant_name(餐廳名稱)、Restaurant_TEL(餐廳電話) 、Restaurant_address(餐廳地址)、Restaurant_x(地圖上餐廳X軸位置)、Restaurant_y(地圖上餐廳Y軸位置)為必填項目。

URL:http://localhost/puli_foodmap/create.php

抓取前端物件:
餐廳名字:'RestaurantName’
餐廳電話:'RestaurantTEL’
簡介:'RestaurantIntro’
營業時間:'RestaurantTime’
照片:'RestaurantPhoto’
評論:RestaurantComment
價錢:RestaurantPrice
地址:RestaurantAdress
X座標:RestaurantX
Y座標:RestaurantY

刪除餐廳 delete.php
API名稱 : 刪除餐廳

檔名: delete.php

HTTP Method: GET

功能說明:
先連接login.php 以 核對使用者權限(登入)，從前端獲取要刪除的餐廳ID，再從資料庫puli_restaurant資料表中刪除那間餐廳所有資訊

URL:http://localhost/puli_foodmap/delete.php

抓取前端的物件:
餐廳ID:‘RestaurantID’

使用者登入 login.php
API名稱:登入網頁

檔名:login.php

HTTP Method:POST

功能說明:
先連接資料庫，並從前端GET使用者帳號&密碼，核對資料庫裏面的帳密，並從資料庫找到該欄使用者，將使用者狀態更改為上線(1)，查看是否為使用者。如果是，登入成功；如果不是，登入失敗 請重新輸入。

抓取前端的物件:
使用者帳號:‘userLogin’
密碼’userPass’
URL:http://localhost/puli_foodmap/login.php

使用者登出 logout.php
API名稱:登出畫面

檔名:logout.php

功能說明:
不需要取得任何資訊，登出時從資料庫找到該欄使用者，將使用者的狀態改為下線(0)，並將session暫存的東西清空。

URL:http://localhost/puli_foodmap/logout.php

篩選餐廳 read_filter.php
API名稱:篩選餐廳

檔名:read_filter.php

HTTP Method:GET

功能說明:
先確認身分為管理員&資料庫使否有連接，從前端取得最小價格、最大價格、類別、時間、距離至少其中一項，若沒有選擇任何篩選條件，則會跳出訊息要求至少選取一個條件。連接資料庫，將符合篩選條件的餐廳列出來轉成json格式傳給前端。

URL:http://localhost/puli_foodmap/read_filter.php

抓取前端的物件:
時間:'time’
類別:'type’
最小價錢:'minPrice’
最大價錢:'maxPrice’
距離:'dis’
使用者位置:‘userLocation’
使用者位置格式[緯度, 經度]

讀取全部餐廳 read.php
API名稱:讀取全部餐廳

檔名:read.php

功能說明:
連接 wordpress資料庫，以讀取 puli_restaurant資料表內的所有餐廳資料。

URL:http://localhost/puli_foodmap/read.php

更新餐廳 update.php
API名稱:更新餐廳資料

檔名:update.php

HTTP Method:PATCH

功能說明:
連接 login.php，確認使用者是否登入、是否有權限。
然後從前端獲取要更新的餐廳ID(Restaurant_ID)、要更新的資料欄位(key)、要更新的值(value)，進而更改資料庫puli_restaurant資料表中更新那間餐廳的資訊。

URL:http://localhost/puli_foodmap/update.php

抓取前端物件:
要更改哪一個選項:'key’
更改後的值:‘value’
