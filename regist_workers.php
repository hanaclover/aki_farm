<?php

require_once( 'initMaster_workers.class.php' );

$dataArr = array(
   'family_name'      => '',
   'first_name'       => '',
   'family_name_kana' => '',
   'first_name_kana'  => '',
   'sex'              => '',
   'year'             => '',
   'month'            => '',
   'day'              => '',
   'shop'             => '',
   'job'              => '',
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
       <title>社員用登録フォーム</title>
  </head>
 <body>
   <center>
   <h1>社員用登録フォーム</h1>
   <center>
       <form action = "confirm_workers.php" method = "post">
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

勤務開始年月日<font color = "red">*</font>

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

ログインID<font color = "red">*</font>
        <input type ="text" name = "ID" value = "<?php echo $dataArr['ID'] ?>" />  <br>

パスワード<font color = "red">*</font>
        <input type ="password" name = "password1" value = "<?php echo $dataArr['password1'] ?>" />  <br>
パスワード再入力<font color = "red">*</font>
        <input type ="password" name = "password2" value = "<?php echo $dataArr['password2'] ?>" />  <br>

所属店舗<font color = "red">*</font>
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "A" >A
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "B" >B
      <input type = "radio" name = "shop" selected = "<?php echo $selectShop ?>" value = "C" >C<br>

職種<font color = "red">*</font>
      <input type = "radio" name = "job" selected = "<?php echo $selectJob ?>" value = "アルバイト" >アルバイト
      <input type = "radio" name = "job" selected = "<?php echo $selectJob ?>" value = "店長" >店長<br>


     <?php //var_dump($dataArr);?>
        <input type = "submit" name = "confirm" value = "登録"><br>  



  </form>  
 </body>
</html>
