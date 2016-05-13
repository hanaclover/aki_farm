<?php

//////default settings/////////////////
require_once("config.php");
require_once("dbClass.php");
require_once("sessionClass.php");
require_once("cartClass.php");
require_once("listControlClass.php");
//////////////////////////////////////

///////////call classes///////////////////////////////////
$db = new Database( db_host, db_user, db_pass, db_name );
$ctr = new control(db_host, db_user, db_pass, db_name );
$cart = new cart("cart");
//////////////////////////////////////////////////////////

$cart->checkSession();

$data = $ctr->cartShow($_SESSION["cart"]);

?>


<!-- ////////HTML-START//////////////////////////////////////////////////////////-->
<html>
<head>
<meta charset="utf-8">
<title>cart</title>
</head>
<body>

<!--////////img-open///////////////////////////////-->
<?php
foreach($data as $value){ 
?>		<img src="<?php echo $value["img"] ?> " 
			 width="200" height="200" alt=""> <?php  
}  
?>
<!--///////////////////////////////////////////////////-->

</body>
</html>

