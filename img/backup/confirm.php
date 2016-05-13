<?php


require_once('error_Check.class.php');
require_once('initMaster.class.php');

$common        = new error_check();

list( $yearArr, $monthArr, $dayArr ) = initMaster::getDate();
arsort($yearArr);

if( isset($_POST["confirm"] )   === true ) $mode = "confirm" ;
if( isset($_POST["back"] )      === true ) $mode = "back" ;
if( isset($_POST["complete"] )  === true ) $mode = "complete" ;
//var_dump($mode); 
switch($mode){
case "confirm":

     unset($_POST["confirm"]);

     $dataArr = $_POST;
   //  var_dump($dataArr);

     if( isset($_POST['sex']) === false ) $dataArr['sex']   = "";

     $errArr = $common->errorCheck( $dataArr );
     $err_check = $common->getErrorFlg();

       $common->htmlEncode( $dataArr );        

       $selectYear = $dataArr['year'];
       $selectMonth = $dataArr['month'];
       $selectDay = $dataArr['day'];

if( $err_check == false){


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
       <form action = "confirm.php" method = "post">
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
              <input type="text" name = "family_name_kana" value="<?php echo $dataArr['first_name_kana']; /*valueは初期値*/?>" /><br>

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
       <form action = "confirm.php" method = "post">
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

case "back":

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
       <form action = "confirm.php" method = "post">
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

$name      = $dataArr["family_name"].$dataArr["first_name"];
$name_kana = $dataArr["family_name_kana"].$dataArr["first_name_kana"];
$birth     = $dataArr["year"].$dataArr["month"].$dataArr["day"];
$tel       = $dataArr['tel1'].$dataArr['tel2']. $dataArr['tel3'];
//$date = date("Y年n月j日");
$type = "お客様";
$sex  = $dataArr["sex"];
$email = $dataArr["email"];
$ID   = $dataArr["ID"];
$password = $dataArr["password1"];
//echo $date;

//echo $tel . "<br>"; 

//echo $name;

$link = mysqli_connect('localhost','user','password','Akifarm_db');
 if(mysqli_connect_errno($link)){
  echo "inncorect";
 }

mysql_set_charset('utf8');

 $sql = "INSERT INTO regist(name,
                             kana,
                             sex,
                             birthday,
                             tel,
                             mail,
                             regist_ID,
                             password,
                             type)
                      VALUES('$name',
                             '$name_kana',
                             '$sex',
                             '$birth',
                             '$tel',
                             '$email',
                             '$ID',
                             '$password',
                             '$type')";

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
       <title>登録完了</title>
  </head>
 <body>
   <center>
   <h1>登録完了しました。</h1>
   </center>
 </body>
</html>

 

<?php
break; exit;
}?>


