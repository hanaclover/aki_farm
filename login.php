<?php

require_once('database_class.php');  //データベースクラス
require_once('To_hash_class.php');  //ハッシュ化クラス

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
$errorMessage1= ""; 

//ログインボタンが押された時
if (isset($_POST["login"])) { 

   if (empty($_POST["userid"]))
     $errorMessage = "ユーザーIDが未入力です。";
   if (empty($_POST["password"])) 
     $errorMessage1 = "パスワードが未入力です。";
   
//ユーザー名、パスワードに何かしら入っていた時
if (!empty($_POST["userid"]) && !empty($_POST["password"])) {

//データベースクラス呼出
$db = new database();

//ハッシュ化クラス呼出
$hs = new tohash();

//セッションにはユーザーID入れておく
$_SESSION["USERID"] = $_POST["userid"];

//入力IDからデータベース参照
$table = "regist";
$column = "";
$where = "User_ID = '" .  $_POST["userid"] . "'";
$password_db = array();
$password_db = $db->select($table, $column, $where);  

//$arart = $db->IDCheck($table, $column, $where);

//データベースに同じIDの情報があったか確認
$counts = count($password_db);

//入力パスワードハッシュ化
$password=$hs->to_hash($_POST["password"]);

if($counts>=1){  //データベースに同じIDの情報があった時

//退会していないかの確認
if($password_db[0]["dlt_flg"] == 0){

//パスワード確認
if($password_db[0]["Password"] == $password){
  echo "認証に成功しました";

//セッションに苗字を入れる「〜様ようこそ」用
  session_regenerate_id(true);
  $_SESSION["NAME"] = $password_db[0]["FamilyName"];
  $_SESSION["FIRSTNAME"]=$password_db[0]["FirstName"];
  $_SESSION["ID"]=$password_db[0]["User_ID"];
//タイプに応じて飛ぶページをカエル
  if($password_db[0]["Type"]=="お客様")
  header("Location: test.php");
  if($password_db[0]["Type"]=="アルバイト")
  header("Location: shift_worker.php");
  if($password_db[0]["Type"]=="店長")
  header("Location: shift_manager.php");

  exit;
}else{ //error Message
  echo "認証に失敗しました。";
  print_r($password_db[0]["Password"]);
  print_r($password);
} }else{$errorMessage1 = "ユーザーIDもしくはパスワードが違います。";
} }else{
 $errorMessage1 = "ユーザーIDもしくはパスワードが違います。";
 }
 }else{}
}

?>

<html>
  <head>
    <meta charset = "utf-8" />
    <title> ログイン </title>
  </head>
  <body>
  <center>
    <h1>ログイン</h1>
  <center>
  <form action = "" method = "post">
  </center>
  <label for="userid">ユーザーID</label><input type="text" id = "userid" name = "userid" value = "">
  <br><?php echo $errorMessage;?><br>
  <label for = "password">パスワード</label><input type="password" id = "password" name = "password" value = "">
  <br><?php echo $errorMessage1;?><br>
  <input type="submit" id="login" name = "login" value = "ログイン"><br>
   <a href="regist.php" >新規登録はこちら</a><br>   
   <a href="regist_delete.php" >退会はこちら</a><br>   
   <a href="regist_workers.php" >社員登録はこちら（仮）</a><br>   
   <a href="regist_login.php" >登録変更はこちら（仮）</a><br>   
   </form>
  </body>
</html>

