<?php
/////if you have geted GET["sort,search"]///////
if(empty($_GET["sort"])){
	$_GET["sort"] = "";
}
if(empty($_GET["searchword"])){
	$_GET["searchword"] = "";
}
//////////////////////////////////////////////////

/////if you have geted GET["add"]///////////////////
if(empty($_GET["add"])){
	$_GET["add"] = "";
}else{
	$_SESSION["cart"] = $cart->buttonAdd($_GET["add"]);
}
/////////////////////////////////////////////////////

/////if you have geted GET["delete"]///////////////////
if(empty($_GET["delete"])){
	$_GET["delete"] = "";
}else{
	$_SESSION["cart"] = $cart->buttonDel($_GET["delete"]);
}
///////////////////////////////////////////////////////

?>
