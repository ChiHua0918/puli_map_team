<!DOCTYPE html>
<!-- 字型 -->
<html lang="en">
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="description" content=" " />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@700&display=swap" rel="stylesheet">
    <title>埔里美食地圖</title>
    <style type="text/css">
        @media screen and (max-width: 1532px) {
            body {
                background-image: url("/src/食物背景透明3.png");
                /* background-repeat: no-repeat; */
                background-size: auto 100%;
                background-position: center center;
                background-attachment: fixed;
            }
        }

        @media screen and (min-width: 1532px) {
            body {
                background-image: url("/src/食物背景透明3.png");
                background-repeat: no-repeat;
                background-size: 100% auto;
                background-position: center center;
                background-attachment: fixed;
            }
        }

        /* 按鈕 */
        #btn {
            /* position: absolute;
            top: calc(50vh - 25px);
            left: calc(50vw - 60px); */
            font-size: 16px;
            width: 120px;
            height: 50px;
            line-height: 28px;
            text-align: center;
            color: white;
            background-color: #f06b1e;
            border-radius: 6px;
            border: 0;
        }

        /* 移到按鈕會變顏色和鼠標 */
        #btn:hover {
            background-color: #f09561;
            cursor: pointer;
        }

        @media screen and (min-width: 1112px) {
            #dialog {
                position: absolute;
                top: calc(52vh - 250px);
                right: 22vw;
            }

            .dialog-bottom {
                margin-bottom: 40px;
                width: 350px;
                height: 100px;
                background: #e7b394;
                position: relative;
                border-radius: 10px;
            }

            .dialog-bottom:after {
                border-color: #e7b394 #e7b394 transparent transparent;
                border-style: solid;
                /* 設定邊框大小可拼湊出任意形狀的三角形 */
                border-width: 20px 25px 20px 25px;
                bottom: -20px;
                /* 必須指定，才能顯示內容 */
                content: "";
                height: 0px;
                right: 40px;
                /* 必須指定，否則會變梯形 */
                position: absolute;
                width: 0px;
            }

            .dialogContent {
                font-family: 'Noto Sans TC', sans-serif;
                line-height: 80px;
                font-size: 25px;
                font-weight: bold;
                color: #f06b1e;
            }

            #arrow {
                position: absolute;
                top: calc(52vh - 175px);
                right: calc(22vw + 10px);
                color: #f06b1e;
                z-index: 2;
            }
        }

        @media screen and (max-width: 1112px) {
            #dialog {
                display: none;
            }

            #arrow {
                display: none;
            }

            /* img {
                display:none;
            } */
        }

        @media screen and (min-width: 800px) {
            #rec {
                position: absolute;
                top: calc(29vh - 25px);
                left: calc(8vw + 0px);
                /* margin: 190px 250px; */
                width: 550px;
                height: 250px;
                background-color: rgba(231, 179, 148, 0.8);
                border-radius: 15px;
                text-align: center;
            }

            #recbtn {
                margin: -50px auto;
            }

            h1 {
                font-family: 'Noto Sans TC', sans-serif;
                padding: 20px;
                /* position: absolute;
                top: calc(50vh - 175px);
                left: calc(50vw - 3em); */
                color: #f06b1e;
                font-size: 4em;
                text-shadow: 0.05em 0.05em 0.05em #777777;
            }

            img {
                position: absolute;
                top: calc(50vh - 100px);
                right: calc(12vw + 10px);
                height: 430px;
                -webkit-transform: scaleX(-1);
                transform: scaleX(-1);
            }
        }

        @media screen and (max-width: 800px) {
            #rec {
                position: absolute;
                top: calc(27vh - 25px);
                left: calc(5vw + 25px);
                /* margin: 190px 250px; */
                width: 400px;
                height: 200px;
                background-color: rgba(231, 179, 148, 0.8);
                border-radius: 15px;
                text-align: center;
            }

            #recbtn {
                margin: -30px auto;
            }

            h1 {
                font-family: 'Noto Sans TC', sans-serif;
                padding: 5px;
                /* position: absolute;
                top: calc(50vh - 140px);
                left: calc(50vw - 3em); */
                color: #f06b1e;
                font-size: 3em;
                text-shadow: 0.05em 0.05em 0.05em #777777;
            }

            img {
                position: absolute;
                top: calc(50vh - 30px);
                right: 50px;
                height: 350px;
                -webkit-transform: scaleX(-1);
                transform: scaleX(-1);
            }
        }
    </style>
</head>

<body>
    <div id="rec">
        <h1>埔里美食地圖</h1>
        <div id="recbtn"><input type="button" id="btn" class="btn" value="START"
                onclick="location.href='/puli_map_team-MVC/view/MapView.php'"></div>
    </div>
    <!-- 對話框 -->
    <div id="dialog" class="dialog-bottom"></div>
    <i id="arrow" class="fas fa-chevron-circle-right" onclick="changetext()"></i>
    <!-- 人物圖片 -->
    <img src="/puli_map_team-MVC/src/person2.png" />
</body>
<script src="https://kit.fontawesome.com/f1181f4d88.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    // window.onload = function () {
    //     var text = ["歡迎蒞臨埔里美食地圖網站", "點擊START開始使用", "還有什麼開場白", "我想不到了", "只是先打一些來測試"];
    //     var showText;
    //     var num = 0;
    //     showText = "<marquee loop=0 class='dialogContent'>" + text[num] + "</marquee>";
    //     document.getElementById("dialog").innerHTML = showText;
    //     document.getElementById("dialog").onclick = changeText();
    // }
    var text = ["大家好我是住在埔里的Paula，想吃美食的話，問我就找對人了啦!",
    "快來跟我一起去尋找埔里美食吧~", 
    "點擊START開始使用", 
    "還在煩惱埔里有甚麼吃的?",
    "不知道今天晚餐吃甚麼?",
    "問paula我就對啦~ 我收集超多家美食，迫不急待與你分享美味的食物！"];
    var showText;
    var num = 0;
    showText = "<marquee loop=0 class='dialogContent'>" + text[num] + "</marquee>";
    document.getElementById("dialog").innerHTML = showText;
    function intRandom(a, b) {
        return Math.floor(a + Math.random() * (b - a + 1));
    }
    function changetext() {
        if (num >= text.length-1) {
            showText = "<marquee loop=0 class='dialogContent'>" + text[intRandom(0, text.length-1)] + "</marquee>";
            document.getElementById("dialog").innerHTML = showText;
        }
        else {
            num += 1;
            showText = "<marquee loop=0 class='dialogContent'>" + text[num] + "</marquee>";
            document.getElementById("dialog").innerHTML = showText;
        }
    }
    // function changeText(text, num) {
    //     // window.alert("hi");     // test
    //     for (let i = 1; i <= text.length; i++) {
    //         // window.alert(num);    // test
    //         num++;
    //         if (num == 5) {
    //             num = 0;
    //             i = 1;
    //         }
    //     }
    //     window.alert("hi again");   //test
    // };
</script>

</html>