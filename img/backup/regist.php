<?php

require_once( 'initMaster.class.php' );

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

//var_dump($dataArr);

list( $yearArr, $monthArr, $dayArr ) = initMaster::getDate();
$sexArr = initMaster::getSex();

arsort($yearArr); 

$selectYear = date("Y");
$selectMonth = date("m");
$selectDay  =  date("d");

?>

<html>
  <head>
     <meta charset = "utf-8">
       <title>登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>登録フォーム</h1>
   <center>
       <form action = "confirm.php" method = "post">
   </center>
お名前（氏名）<font color = "red">*</font>
              <input type="text" name = "family_name" value="<?php echo $dataArr['family_name'] /*valueは初期値*/?>" />    
              <input type="text" name = "first_name" value="<?php echo $dataArr['first_name'] /*valueは初期値*/?>" /><br>    

お名前（かな）<font color = "red">*</font>
              <input type="text" name = "family_name_kana" value="<?php echo $dataArr['family_name_kana'] /*valueは初期値*/?>" />    
              <input type="text" name = "first_name_kana" value="<?php echo $dataArr['first_name_kana'] /*valueは初期値*/?>" /><br>

性別<font color = "red">*</font>
      <input type = "radio" name = "sex" selected = "<?php echo $selectSex ?>" value = "0" >男
      <input type = "radio" name = "sex" selected = "<?php echo $selectSex ?>" value = "1" >女<br>

生年月日<font color = "red">*</font>

<select name = "year">
     <option selected></option>
     <?php foreach( $yearArr as $yearArr){ ?>
     <option value = "<?php echo $yearArr ?>"><?php echo $yearArr ?>
     </option>

     <?php } ?>
</select>年

<select name = "month">
     <option selected></option>
     <?php foreach( $monthArr as $monthArr){ ?>
     <option value = "<?php echo $monthArr ?>"><?php echo $monthArr ?>
     </option>

     <?php } ?>
</select>月

<select name = "day">
     <option selected></option>
     <?php foreach( $dayArr as $dayArr){ ?>
     <option value = "<?php echo $dayArr ?>"><?php echo $dayArr ?>
     </option>

     <?php } ?> 
</select>日 <br>

電話番号<font color = "red">*</font>
        <input type="text" name = "tel1" value="<?php echo $dataArr['tel1'] /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel2" value="<?php echo $dataArr['tel2'] /*valueは初期値*/?>" /> -    
        <input type="text" name = "tel3" value="<?php echo $dataArr['tel3'] /*valueは初期値*/?>" /> <br>    

Eメールアドレス<font color = "red">*</font>
        <input type ="text" name = "email" value = "<?php echo $dataArr['email'] ?>" />  <br>

ログインID<font color = "red">*</font>
        <input type ="text" name = "ID" value = "<?php echo $dataArr['ID'] ?>" />  <br>

パスワード<font color = "red">*</font>
        <input type ="password" name = "password1" value = "<?php echo $dataArr['password1'] ?>" />  <br>
パスワード再入力<font color = "red">*</font>
        <input type ="password" name = "password2" value = "<?php echo $dataArr['password2'] ?>" />  <br>

     <?php //var_dump($dataArr);?>
        <input type = "submit" name = "confirm" value = "登録"><br>  
  </form>  
 </body>
</html>
