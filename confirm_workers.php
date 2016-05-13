<?php


require_once('error_Check_workers.class.php');
require_once('initMaster_workers.class.php');
require_once('database_class.php');
require_once('To_hash_class.php');
require_once('make_shift_class.php');

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
//     var_dump($dataArr);

     if( isset($_POST['sex']) === false ) $dataArr['sex']   = "";
     if( isset($_POST['shop']) === false ) $dataArr['shop']   = "";
     if( isset($_POST['job']) === false ) $dataArr['job']   = "";

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
       <title>社員用登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>社員用登録フォーム</h1>
   <center>
       <form action = "confirm_workers.php" method = "post">
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


勤務開始年月日<font color = "red">*</font>

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

所属店舗<font color = "red">*</font>
      <input type = "radio" name = "shop[]" selected = "<?php echo $selectShop ?>" value = "A" >A
      <input type = "radio" name = "shop[]" selected = "<?php echo $selectShop ?>" value = "B" >B
      <input type = "radio" name = "shop[]" selected = "<?php echo $selectShop ?>" value = "C" >C<br>
        <?php if($errArr['shop'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['shop'];} ?> </font>

職種<font color = "red">*</font>
      <input type = "radio" name = "job[]" selected = "<?php echo $selectJob ?>" value = "アルバイト">アルバイト
      <input type = "radio" name = "job[]" selected = "<?php echo $selectJob ?>" value = "店長">店長<br>
        <?php if($errArr['job'] !== ''){ ?>
        <font color = "red"><?php echo $errArr['job'];} ?> </font>



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
       <form action = "confirm_workers.php" method = "post">
   </center>
お名前（氏名）<?php echo $dataArr['family_name']; ?> <?php echo $dataArr['first_name']; ?>   <br>    
お名前（かな）<?php echo $dataArr['family_name_kana']; ?> <?php echo $dataArr['first_name_kana']; ?> <br>    

性別 <?php if($dataArr['sex'] === '0'){
                      echo "男性";
           }elseif($dataArr['sex'] === '1'){
                      echo "女性";
           }?> <br>

勤務開始年月日 <?php echo $selectYear; ?>年
         <?php echo $selectMonth; ?>月
         <?php echo $selectDay; ?>日<br>
         
ログインID <?php echo $dataArr['ID']; ?>  <br>

パスワード <?php echo "***********"/*$dataArr['password1']*/; ?> <br>

所属店舗  <?php  echo $dataArr['shop'][0]; ?><br>

職種      <?php echo $dataArr["job"][0];   ?><br>

        <input type = "submit" name = "back" value = "戻る"/>
        <input type = "submit" name = "complete" value = "登録完了"/><br>  
        <?php foreach( $dataArr as $key => $value) { ?>
          <?php if(is_array($value)) { ?> 
            <?php foreach( $value as $v ){ ?>
              <input type = "hidden" name = "<?php echo $key ?>[]" value= "<?php echo $v; ?>" />
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
       <title>社員用登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>社員用登録フォーム</h1>
   <center>
       <form action = "confirm_workers.php" method = "post">
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

ログインID<font color = "red">*</font>
        <input type ="text" name = "ID" value = "<?php echo $dataArr['ID']; ?>" />  <br/>

パスワード<font color = "red">*</font>
        <input type ="password" name = "password1" value = "<?php echo $dataArr['password1']; ?>" />  <br/>

パスワード再入力<font color = "red">*</font>
        <input type ="password" name = "password2" value = "<?php echo $dataArr['password2']; ?>" />  <br/>

所属店舗<font color = "red">*</font>
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "A" >A
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "B" >B
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "C" >C<br>

職種<font color = "red">*</font>
      <input type = "radio" name = "job[]" selected = "<?php echo $selectJob ?>" value = "アルバイト">アルバイト
      <input type = "radio" name = "job[]" selected = "<?php echo $selectJob ?>" value = "店長">店長<br>

        <input type = "submit" name = "confirm" value = "確認"/><br/>  
  </form> 
 </body>
</html>

<?php break; exit;

case "complete":

$dataArr = $_POST;

unset($dataArr["complete"]);

$hs= new tohash();

$family_name      = $dataArr["family_name"];
$first_name       = $dataArr["first_name"];
$family_name_kana = $dataArr["family_name_kana"];
$first_name_kana  = $dataArr["first_name_kana"];
$name             = $family_name.$first_name;
$birth     = $dataArr["year"].$dataArr["month"].$dataArr["day"];
$type = $dataArr["job"];
$sex  = $dataArr["sex"];
$ID   = $dataArr["ID"];
$password = $hs->to_hash($dataArr["password1"]);
$shop = $dataArr["shop"];

//echo $tel . "<br>"; 

$link = mysqli_connect('localhost' ,'user' ,'password', 'Akifarm_db');
  if(mysqli_connect_errno($link)){
     echo "inncorect";
  }

//into regist_table
//mysql_set_charset('utf8');
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
                            Type)
                      VALUES('$family_name',
                             '$first_name',
                             '$family_name_kana',
                             '$first_name_kana',
                             '$sex',
                             ' ',
                             ' ',
                             ' ',
                             '$ID',
                             '$password',
                             '$type')";

  echo $sql;
  $result = mysqli_query($link,$sql);
  if(!$result){
   echo "error" . mysqli_error($link);
  }
  mysqli_close($link);


$link = mysqli_connect('localhost' ,'user' ,'password', 'Akifarm_db');
  if(mysqli_connect_errno($link)){
     echo "inncorect";
  }
//into workers
//mysql_set_charset('utf8');
$sql = "INSERT INTO workers( FamilyName,
                            FirstName,
                            FamilyName_kana,
                            FirstName_kana,
                            Sex,
                            StartTime,
                            Store,
                            User_ID,
                            Password
                                  )
                      VALUES('$family_name',
                             '$first_name',
                             '$family_name_kana',
                             '$first_name_kana',
                             '$sex',
                             '$birth',
                             '$shop',
                             '$ID',
                             '$password'
                                 )";

  echo $sql;
  $result = mysqli_query($link,$sql);
  if(!$result){
   echo "error" . mysqli_error($link);
  }

//into shift_submit

for($i=1;$i<=12;$i++){
  $db     = new database();
  $tbl    = "shift_submit";
  $col    = "name, user_id, shift_year, shift_month, shift_data, submit_time, delete_flg";
  $oppai  = make_shift(2016,$i);
  $data   = "'" . $name ."','". $ID . "' ,'', '". $i ."','" . $oppai ."' , '',''";

  $result= $db->insert($tbl, $col, $data); 
}
 
for($i=1;$i<=12;$i++){
  $tbl    = "shift_fix";
  $col    = "name, user_id, shift_year, shift_month, shift_data, fix_time, delete_flg";
  $oppai  = make_shift(2016, $i);
  $data   = "'','". $ID . "' ,'', '". $i ."','" . $oppai ."' , '',''";

  $result = $db->insert($tbl, $col, $data);
}
?>

<html>
  <head>
     <meta charset = "utf-8"/>
       <title>登録完了</title>
  </head>
 <body>
   <center>
   <h1>登録完了しました。</h1><br>
   <?php if($type==="アルバイト" ){ ?>
   <a href= "shift_worker.php">シフトページへ</a><br>
   <?php } ?>
    <?php if($type==="店長" ){ ?>
   <a href= "shift_manager.php">シフトページへ</a><br>
   <?php } ?>
  </center>
 </body>
</html>

 

<?php
break; exit;
}?>


