<?php

 $link = mysqli_connect('localhost','user','password','Akifarm_db');
 $sql  = "SELECT * FROM regist WHERE User_ID = 'loginid1'";
 $qry  = mysqli_query($link , $sql);
 $data = array();
 if(!$qry){echo "error" . mysqli_error($link);}
 while($row=mysqli_fetch_assoc($qry)){
      $data[]=$row;
 } 
 var_dump($data);

?>
