<!DOCTYPE html>
<!-- 字型 -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>登入頁面</title>
  <!-- <link rel="stylesheet" type="text/css" href="login.css"/>
  <script type="text/javascript" src="login.js"></script> -->
</head>
<style type="text/css">

  /* 整個表格 */
  #login_frame {
    width: 400px;
    height: 260px;
    padding: 13px;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -200px;
    margin-top: -200px;
    background-color: #0a242b(240, 255, 255, 0.5);
    border-radius: 10px;
    text-align: center;
  }
  form p > * {
    display: inline-block;
    /* 用於垂直文本內的圖片 */
    vertical-align: middle;
  }
  #image_logo {
    margin-top: 22px;
  }
  /* 使用者名稱/密碼的左邊 */
  /* .label_input {
  font-size: 16px;
  font-family: 宋體;
  width: 85px;
  height: 28px;
  line-height: 28px;
  text-align: center;
  color: white;
  background-color: #0a242b;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  } */
  /* 使用者名稱/密碼 */
  .text_field {
    width: 270px;
    height: 28px;
    border-radius: 5px;
    border: solid #0a242bab;
    outline: none;
  }
  /* 點選使用者名稱/密碼邊框會換色 */
  input[type=text]:focus {
    border: 3px solid #8ab3be;
  }
  /* 登入按鈕 */
  #btn_login {
    font-size: 16px;
    font-family: 宋體;
    width: 90px;
    height: 28px;
    line-height: 28px;
    text-align: center;
    color: white;
    background-color: #0a242b;
    border-radius: 6px;
    border: 0;
    float: center;
  }
  /* 忘記密碼 */
  #forget_pwd {
    font-size: 14px;
    color: #0a242b;
    text-decoration: none;
    position: relative;
    float: center;
    top: 5px;
  }
  #forget_pwd:hover {
    color: #8ab3be;
    text-decoration: underline;
  }
  #login_control{
    padding: 10px;
  }
  #bg {
    background-image: url("/src/食物背景透明3.png");
    /* background-repeat: no-repeat; */
    background-size: auto 100%;
    background-position: center center;
    background-attachment: fixed;
  }

</style>
<body>
  <div id="login_frame">
    <form action="/controller/login.php" method="POST">
      <p><input type="text" name="userLogin" id="username" class="text_field" placeholder="使用者名稱"/></p>
      <p><input type="password" name="userPass" id="password" class="text_field" placeholder="密碼"/></p>
      <!-- <a id="forget_pwd" href="forget_pwd.html">忘記密碼</a> -->
      <div id="login_control">
        <input type="submit" id="btn_login" value="登入"/>
      </div>
    </form>
  </div>
</body>
</html>