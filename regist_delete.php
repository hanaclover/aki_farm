<?php

require_once('database_class.php');  //データベースクラス
require_once('To_hash_class.php');   //ハッシュ化クラス

session_start(); //セッション開始

//データベース情報

/*
$db['host']   = "localhost";
$db['user']   = "user";
$db['pass']   = "password";
$db['dbname'] = "Akifarm_db";
*/

//エラーメッセージ初期化
$errorMessage = "";  
$errorMessage1 = "";


//ログインボタンが押された時
if (isset($_POST["delete"])) { 

   if (empty($_POST["userid"]))
     $errorMessage = "ユーザーIDが未入力です。";
   if (empty($_POST["password"])) 
     $errorMessage1 = "パスワードが未入力です。";
   
//ユーザー名、パスワード何かしら入っていた時
if (!empty($_POST["userid"]) && !empty($_POST["password"])) {

//データベースクラス呼出
$db = new database();

//ハッシュ化クラス呼出
$hs = new tohash();

//セッションに一応入れておく
$_SESSION["USERID"] = $_POST["userid"];

//入力IDからデータベース参照
$table = "regist";
$column = "";
$where = "User_ID = '" .  $_POST["userid"] . "'";
$password_db = array();
$password_db = $db->select($table, $column, $where);  

//データベースに同じIDのものがあったか確認
$counts = count($password_db);

//入力パスワードハッシュ化
$password=$hs->to_hash($_POST["password"]);


if($counts>=1){  //データベースに同じIDの情報があった時

//パスワード確認
if($password_db[0]["Password"] == $password){
  echo "登録を削除しました。";
  
//session destroy
  $_SESSION = array();
 if(isset($_COOKIE[session_name()])){
      setcookie(session_name(), '', time()-42000, '/');
 }
  session_destroy();

//列を特定しデリーとフラグを1にする。非会員とみなす。
  $setcol = "dlt_flg";
  $value1 = 1;
  $wherecol = "User_ID";
  $value2 = $_POST["userid"];
  $result = $db->update($table, $setcol, $value1, $wherecol, $value2);

  exit;
}else{
  echo "認証に失敗しました。";
  print_r($password_db[0]["Password"]);
  print_r($password);
} 
}else{
 $errorMessage1 = "ユーザーIDもしくはパスワードが違います。";
}
}else{}
}

?>

<html>
  <head>
    <meta charset = "utf-8" />
    <title> 登録削除 </title>
  </head>
  <body>
  <center>
    <h1>登録削除</h1>
  <center>
  <form action = "" method = "post">
  </center>
  <label for="userid">ユーザーID</label><input type="text" id = "userid" name = "userid" value = "">
  <br><?php echo $errorMessage;?><br>
  <label for = "password">パスワード</label><input type="password" id = "password" name = "password" value = "">
  <br><?php echo $errorMessage1;?><br>
  <input type="submit" id="delete" name = "delete" value = "退会">
   </form>
  </body>
</html>

