<?php

require_once('database_class.php'); //データベースクラス
require_once('To_hash_class.php');  //ハッシュ化クラス
require_once('initMaster.class.php');//マスター
require_once('error_Check.class.php');//エラーチェック

session_start();

//入力IDからデータベース参照
$db = new database();

$table = "regist";
$column = "";
$where = "Password = '" .  $_SESSION["Pass"] . "'";
$password_db = array();
$password_db = $db->select($table, $column, $where);  

//$password_dbにはレジストの情報が

//データベースに同じIDの情報があったか確認
$counts = count($password_db);

//セッションに苗字を入れる「〜様ようこそ」用
  session_regenerate_id(true);
  $_SESSION["USERID"] = $password_db[0]["FamilyName"];

$dataArr = array(
   'family_name'      => '',
   'first_name'       => '',
   'family_name_kana' => '',
   'first_name_kana'  => '',
   'sex'              => '',
   'year'             => '',
   'month'            => '',
   'day'              => '',
   'tel1'             => '',
   'tel2'             => '',
   'tel3'             => '',
   'email'            => '',
   'ID'               => '',
   'password1'         => '',
   'password2'         => ''
);

///////この部分は再帰的な処理でもっとかんけつにできる。/////

$tel = array();
$tel = explode( '-', $password_db[0]['PhoneNum']); 
var_dump($_SESSION["Pass_Raw"]);

$dataArr['family_name']      = $password_db[0]['FamilyName'];
$dataArr['first_name']       = $password_db[0]['FirstName'];
$dataArr['family_name_kana'] = $password_db[0]['FamilyName_kana'];
$dataArr['first_name_kana']  = $password_db[0]['FirstName_kana'];
$dataArr['sex']              = $password_db[0]['Sex'];
$dataArr['year']             = substr($password_db[0]['Birthday'],0,4); 
$dataArr['month']            = substr($password_db[0]['Birthday'],4,2);
$dataArr['day']              = substr($password_db[0]['Birthday'],-2);
$dataArr['tel1']             = $tel[0];
$dataArr['tel2']             = $tel[1];
$dataArr['tel3']             = $tel[2];
$dataArr['email']            = $password_db[0]['Mail'];
$dataArr['ID']               = $password_db[0]['User_ID'];
$dataArr['password1']        = $_SESSION["Pass_Raw"];
$dataArr['password2']        = '';

///////この部分は再帰的な処理でもっとかんけつにできる。/////
//var_dump($password_db);

//$common        = new error_check();

  //     $common->htmlEncode( $dataArr );        



       $selectYear = $dataArr['year'];
       $selectMonth = $dataArr['month'];
       $selectDay = $dataArr['day'];
  $mode="first";

  if($mode=="first"){
?>

<!-- 最初に表示 --!>

<html>
  <head>
     <meta charset = "utf-8"/>
       <title>登録情報確認</title>
  </head>
<body>
   <center>
   <h1>登録情報確認</h1>
   <center>
       <form action = "regist_change.php" method = "post">
   </center>
お名前（氏名）<?php echo $dataArr['family_name']; ?> <?php echo $dataArr['first_name']; ?>   <br>    
お名前（かな）<?php echo $dataArr['family_name_kana']; ?> <?php echo $dataArr['first_name_kana']; ?> <br>    

性別 <?php if($dataArr['sex'] === '0'){
                      echo "男性";
           }elseif($dataArr['sex'] === '1'){
                      echo "女性";
           }?> <br>

生年月日 <?php echo $selectYear; ?>年
         <?php echo $selectMonth; ?>月
         <?php echo $selectDay; ?>日<br>
         

電話番号   <?php echo $dataArr['tel1'] . "-" . $dataArr['tel2'] . "-" . $dataArr['tel3'];?> <br>    

Eメールアドレス <?php echo $dataArr['email']; ?> <br>

ログインID <?php echo $dataArr['ID']; ?>  <br>

パスワード <?php echo "***********"/*$dataArr['password1']*/; ?> <br>

        <input type = "submit" name = "back" value = "項目表示"/>
        <input type = "submit" name = "complete" value = "変更完了"/><br>  
        <?php foreach( $dataArr as $key => $value) { ?>
          <?php if(is_array($value)) { ?> 
            <?php foreach( $value as $v ){ ?>
 /*nazo*/       <input type = "hidden" name = "<?php echo $key ?>[]" value= "<?php echo $v; ?>" />
        <?php } ?>
        <?php }else{ ?>
        <input type = "hidden" name = "<?php echo $key; ?>" value="<?php echo $value; ?>" /> 
        <?php } ?>
        <?php } ?>
  </form>  
 </body>
</html>  

<?php
 }
$common        = new error_check();

list( $yearArr, $monthArr, $dayArr ) = initMaster::getDate();
arsort($yearArr);

if( isset($_POST["confirm"] )   === true ) $mode = "confirm" ;
if( isset($_POST["back"] )      === true ) $mode = "back" ;
if( isset($_POST["complete"] )  === true ) $mode = "complete" ;
 
switch($mode){
case "confirm":

     unset($_POST["confirm"]);

     $dataArr = $_POST;


     if( isset($_POST['sex']) === false ) $dataArr['sex']   = "";

     $errArr = $common->errorCheck( $dataArr );
     $err_check = $common->getErrorFlg();

       $common->htmlEncode( $dataArr );        

       $selectYear = $dataArr['year'];
       $selectMonth = $dataArr['month'];
       $selectDay = $dataArr['day'];

if( $err_check == false){//登録情報に不備がある時
?>

<html>
  <head>
     <meta charset = "utf-8"/>
       <title>登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>登録フォーム</h1>
   <center>
       <form action = "regist_change.php" method = "post">
   </center>
お名前（氏名）<font color = "red">*</font>
              <input type="text" name = "family_name" value="<?php echo $dataArr['family_name']; /*valueは初期値*/?>" />    
              <input type="text" name = "first_name" value="<?php echo $dataArr['first_name']; /*valueは初期値*/?>" /><br>    

              <?php if($errArr['family_name'] !== ''){ ?>
         <br /><font color = "red"><?php echo $errArr['family_name']; } ?></font>

              <?php if($errArr['first_name'] !== ''){ ?>
         <br /><font color = "red"><?php echo $errArr['first_name']; } ?></font>


お名前（かな）<font color = "red">*</font>
              <input type="text" name = "family_name_kana" value="<?php echo $dataArr['family_name_kana']; /*valueは初期値*/?>" />    
              <input type="text" name = "first_name_kana" value="<?php echo $dataArr['first_name_kana']; /*valueは初期値*/?>" /><br>

性別<font color = "red">*</font>
      <input type = "radio" name = "sex" value = "0" <?php echo($dataArr['sex'] == "0")?"checked":""; ?> >男
      <input type = "radio" name = "sex" value = "1" <?php echo($dataArr['sex'] == "1")?"checked":""; ?> >女<br>

      <?php if( $errArr['sex'] !== ''){ ?><br /><font color="red"><?php echo $errArr['sex']; } ?></font>


生年月日<font color = "red">*</font>

<select name = "year">
     <option selected><?php echo $selectYear; ?></option>

     <?php foreach( $yearArr as $yearArr){ ?>
     <option value = "<?php echo $yearArr; ?>"><?php echo $yearArr; ?>
     </option>

     <?php } ?>
</select>年

<select name = "month">
     <option selected><?php echo $selectMonth; ?></option>
     <?php foreach( $monthArr as $monthArr){ ?>
     <option value = "<?php echo $monthArr; ?>"><?php echo $monthArr; ?>
     </option>

     <?php } ?>
</select>月

<select name = "day">
     <option selected><?php echo $selectDay; ?></option>
     <?php foreach( $dayArr as $dayArr){ ?>
     <option value = "<?php echo $dayArr; ?>"><?php echo $dayArr; ?>
     </option>

     <?php } ?> 
</select>日 <br>

    <?php if($errArr['year'] !== ''){ ?><br/>
    <font color="red"> <?php echo $errArr['year']; }?></font>

    <?php if($errArr['month'] !== ''){ ?><br/>
    <font color="red"> <?php echo $errArr['month']; }?></font>

    <?php if($errArr['day'] !== ''){ ?><br/>
    <font color="red"> <?php echo $errArr['day']; }?></font><br/>



電話番号<font color = "red">*</font>
        <input type="text" name = "tel1" value="<?php echo $dataArr['tel1']; /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel2" value="<?php echo $dataArr['tel2']; /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel3" value="<?php echo $dataArr['tel3']; /*valueは初期値*/?>" /> <br>    

        <?php if( $errArr['tel1'] !== ''){ ?>
           <br /><font color="red"><?php echo $errArr['tel1']; }?></font>
        <?php if( $errArr['tel2'] !== ''){ ?>
           <br /><font color="red"><?php echo $errArr['tel2']; }?></font>
        <?php if( $errArr['tel3'] !== ''){ ?>
           <br /><font color="red"><?php echo $errArr['tel3']; }?></font>


Eメールアドレス<font color = "red">*</font>
        <input type ="text" name = "email" value = "<?php echo $dataArr['email'] ;?>" />  <br>

        <?php if($errArr['email'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['email'];} ?></font>

ログインID<font color = "red">*</font>
        <input type ="text" name = "ID" value = "<?php echo $dataArr['ID']; ?>" />  <br>
        <?php if($errArr['ID'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['ID'];} ?> </font>

パスワード<font color = "red">*</font>
        <input type ="password" name = "password1" value = "<?php echo $dataArr['password1']; ?>" />  <br>
        <?php if($errArr['password1'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['password1'];} ?> </font> 

パスワード再入力<font color = "red">*</font>
        <input type ="password" name = "password2" value = "<?php echo $dataArr['password2'] ?>" />  <br>
        <?php if($errArr['password2'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['password2'];} ?> </font>

        <input type = "submit" name = "confirm" value = "確認"><br>  
  </form> 
 </body>
</html>

<?php }else{  //登録情報が正しかった時 ?>
  
<html>
  <head>
     <meta charset = "utf-8"/>
       <title>登録情報確認</title>
  </head>
<body>
   <center>
   <h1>登録情報確認</h1>
   <center>
       <form action = "regist_change.php" method = "post">
   </center>
お名前（氏名）<?php echo $dataArr['family_name']; ?> <?php echo $dataArr['first_name']; ?>   <br>    
お名前（かな）<?php echo $dataArr['family_name_kana']; ?> <?php echo $dataArr['first_name_kana']; ?> <br>    

性別 <?php if($dataArr['sex'] === '0'){
                      echo "男性";
           }elseif($dataArr['sex'] === '1'){
                      echo "女性";
           }?> <br>

生年月日 <?php echo $selectYear; ?>年
         <?php echo $selectMonth; ?>月
         <?php echo $selectDay; ?>日<br>
         

電話番号   <?php echo $dataArr['tel1'] . "-" . $dataArr['tel2'] . "-" . $dataArr['tel3'];?> <br>    

Eメールアドレス <?php echo $dataArr['email']; ?> <br>

ログインID <?php echo $dataArr['ID']; ?>  <br>

パスワード <?php echo "***********"/*$dataArr['password1']*/; ?> <br>

        <input type = "submit" name = "back" value = "戻る"/>
        <input type = "submit" name = "complete" value = "登録完了"/><br>  
        <?php foreach( $dataArr as $key => $value) { ?>
          <?php if(is_array($value)) { ?> 
            <?php foreach( $value as $v ){ ?>
 /*nazo*/       <input type = "hidden" name = "<?php echo $key ?>[]" value= "<?php echo $v; ?>" />
        <?php } ?>
        <?php }else{ ?>
        <input type = "hidden" name = "<?php echo $key; ?>" value="<?php echo $value; ?>" /> 
        <?php } ?>
        <?php } ?>
  </form>  
 </body>
</html>  

<?php } ?>

<?php break; exit;

case "back": //戻るボタン押したとき

   $dataArr = $_POST;

   unset($dataArr["back"]);

   foreach( $dataArr as $key => $value){
     $errArr[$key] = "";
   }

     $selectYear = $dataArr['year'];
     $selectMonth = $dataArr['month'];
     $selectDay = $dataArr['day'];

?>

<html>
  <head>
     <meta charset = "utf-8"/>
       <title>登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>登録フォーム</h1>
   <center>
       <form action = "regist_change.php" method = "post">
   </center>
お名前（氏名）<font color = "red">*</font>
              <input type="text" name = "family_name" value="<?php echo $dataArr['family_name']; /*valueは初期値*/?>" />    
              <input type="text" name = "first_name" value="<?php echo $dataArr['first_name']; /*valueは初期値*/?>" /><br>    

              <?php if($errArr['family_name'] !== ''){ ?><br />
              <font color="red"><?php echo $errArr['family_name']; } ?></font>
              <?php if($errArr['first_name'] !== ''){ ?><br />
              <font color="red"><?php echo $errArr['first_name']; } ?></font>

お名前（かな）<font color = "red">*</font>
              <input type="text" name = "family_name_kana" value="<?php echo $dataArr['family_name_kana']; /*valueは初期値*/?>" />    
              <input type="text" name = "first_name_kana" value="<?php echo $dataArr['first_name_kana']; /*valueは初期値*/?>" /><br>

性別<font color = "red">*</font>
      <input type = "radio" name = "sex" value = "0" <?php echo($dataArr['sex'] == "0")?"checked":""; ?> >男
      <input type = "radio" name = "sex" value = "1" <?php echo($dataArr['sex'] == "1")?"checked":""; ?> >女<br>

生年月日<font color = "red">*</font>

<select name = "year">
     <option selected><?php echo $selectYear; ?></option>

     <?php foreach( $yearArr as $yearArr){ ?>
     <option value = "<?php echo $yearArr; ?>"><?php echo $yearArr; ?>
     </option>

     <?php } ?>
</select>年

<select name = "month">
     <option selected><?php echo $selectMonth; ?></option>
     <?php foreach( $monthArr as $monthArr){ ?>
     <option value = "<?php echo $monthArr; ?>"><?php echo $monthArr; ?>
     </option>

     <?php } ?>
</select>月

<select name = "day">
     <option selected><?php echo $selectDay; ?></option>
     <?php foreach( $dayArr as $dayArr){ ?>
     <option value = "<?php echo $dayArr; ?>"><?php echo $dayArr; ?>
     </option>

     <?php } ?> 
</select>日 <br>

電話番号<font color = "red">*</font>
        <input type="text" name = "tel1" value="<?php echo $dataArr['tel1']; /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel2" value="<?php echo $dataArr['tel2']; /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel3" value="<?php echo $dataArr['tel3']; /*valueは初期値*/?>" /> <br/>    

Eメールアドレス<font color = "red">*</font>
        <input type ="text" name = "email" value = "<?php echo $dataArr['email'] ;?>" />  <br/>

ログインID<font color = "red">*</font>
        <input type ="text" name = "ID" value = "<?php echo $dataArr['ID']; ?>" />  <br/>

パスワード<font color = "red">*</font>
        <input type ="password" name = "password1" value = "<?php echo $dataArr['password1']; ?>" />  <br/>

パスワード再入力<font color = "red">*</font>
        <input type ="password" name = "password2" value = "<?php echo $dataArr['password2']; ?>" />  <br/>

        <input type = "submit" name = "confirm" value = "確認"/><br/>  
  </form> 
 </body>
</html>

<?php break; exit;

case "complete":

$dataArr = $_POST;

unset($dataArr["complete"]);

//tableに insertするための準備
$hs = new tohash();
$family_name      = $dataArr["family_name"];
$first_name       = $dataArr["first_name"];
$family_name_kana = $dataArr["family_name_kana"];
$first_name_kana  = $dataArr["first_name_kana"];
$birth     = $dataArr["year"].$dataArr["month"].$dataArr["day"];
$tel       = $dataArr['tel1']."-".$dataArr['tel2']."-". $dataArr['tel3'];
$type = "お客様";
$sex  = $dataArr["sex"];
$email = $dataArr["email"];
$ID   = $dataArr["ID"];
$password = $hs->to_hash($dataArr["password1"]);
$dlt_flg = 0;

//UPDATE HENKOU
$db = new database();
$result = $db->update("regist","FamilyName",$family_name,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","FirstName",$first_name,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","FamilyName_kana",$family_name_kana,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","FamilyName_kana",$first_name_kana,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","Sex",$sex,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","Birthday",$birth,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","PhoneNum",$tel,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","Mail",$email,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","User_ID",$ID,"User_ID",$_SESSION[USERID]);
$result = $db->update("regist","Password",$password,"User_ID",$_SESSION[USERID]);
//$result = $db->update("regist","",$family_name,"User_ID",$_SESSION[USERID]);

 $sql = "INSERT INTO regist( FamilyName,
                             FirstName,
                             FamilyName_kana,
                             FirstName_kana,
                             Sex,
                             Birthday,
                             PhoneNum,
                             Mail,
                             User_ID,
                             Password,
                             Type,
                             dlt_flg)
                      VALUES('$family_name',
                             '$first_name',
                             '$family_name_kana',
                             '$first_name_kana',
                             '$sex',
                             '$birth',
                             '$tel',
                             '$email',
                             '$ID',
                             '$password',
                             '$type',
                             '$dlt_flg')";

  echo $sql;
  $result = mysqli_query($link,$sql);
  if(!$result){
   echo "error" . mysqli_error($link);
  }

/*try{
  $dbh = new PDO("mysql:host=localhost;dbname=Akifarm_db;charset=utf8",
                 "user",
                 "password"
                );
   if($dbh == null){
     print('inncorrect<br>');
   }else{
     print('correct<br>');
   }
  $sql = 'INSERT INTO regist(name,
                             kana,
                             sex,
                             birthday,
                             tel,
                             mail,
                             resigt_ID,
                             password,
                             type)
                      values(:name,
                             :name_kana,
                             :sex,
                             :birth,
                             :tel,
                             :mail,
                             :ID,
                             :password,
                             :type)';
                         
 $stmt = $dbh->prepare($sql);
 $stmt->bindValue(':name', $name, PDO::PARAM_STR);
 $stmt->bindValue(':name_kana', $name_kana, PDO::PARAM_STR);
 $stmt->bindValue(':sex', $dataArr['sex'], PDO::PARAM_INT);
 $stmt->bindValue(':birth', $birth, PDO::PARAM_INT);
 $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
 $stmt->bindValue(':mail', $dataArr['email'], PDO::PARAM_STR);
 $stmt->bindValue(':ID', $dataArr['ID'], PDO::PARAM_STR);
 $stmt->bindValue(':password',$dataArr['password1'], PDO::PARAM_STR);
 $stmt->bindValue(':type',$type,PDO::PARAM_STR);
 $stmt->execute();

 while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
  print($result['type']);
  print($result['password'].'<br>');
 }
} catch (PDOExeption $e) {
     print "エラー！:" . $e->getMessage() . "<br/>";
     die();
}
*/
?>

<html>
  <head>
     <meta charset = "utf-8"/>
       <title>変更完了</title>
  </head>
 <body>
   <center>
   <h1>変更完了しました。</h1><br>
   <a href="test.php">トップページへ</a><br>
   </center>
 </body>
</html>

 

<?php
break; exit;
}?>


  
 



