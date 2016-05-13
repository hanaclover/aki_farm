<?php

  session_start();

  if(!isset($_SESSION["USERID"])) {
   header("Location : logout.php");
   exit;
  }


?>

<html>
  <head>
    <meta charset = "UTF-8">
    <title>お客様ページ</title>
  </head>
  <body>
  <h1>会員様ページです</h1>
  <p>ようこそ<?php echo htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?>さん</p>
  <li><a href="logout.php">ログアウト</a></li>
  </body>
</html>
