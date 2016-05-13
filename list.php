<?php

//////default settings/////////////////
require_once("config.php");
//require_once("./class/dbClass.php");
//require_once("./class/sessionClass.php");
//require_once("./class/cartClass.php");
//require_once("./class/listControlClass.php");
require_once("./class/jsClass.php");
//////////////////////////////////////

///////////call classes///////////////////////////////////
//$db = new Database( db_host, db_user, db_pass, db_name );
//$cart = new cart("cart");
//$cart->checkSession();
//////////////////////////////////////////////////////////


//require_once("ifGET.php");
//require_once("sort_search.php");
//require_once("escape.php");

//$db->close();
//$cnt = count($_SESSION["cart"]);
include_once('./html/list.html');

?>
