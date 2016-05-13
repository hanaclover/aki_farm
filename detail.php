<?php

//////default settings/////////////////
require_once("config.php");
require_once("./class/dbClass.php");
require_once("./class/sessionClass.php");
require_once("./class/cartClass.php");
require_once("./class/listControlClass.php");
require_once("./class/jsClass.php");
//////////////////////////////////////

///////////call classes///////////////////////////////////
$db = new Database( db_host, db_user, db_pass, db_name );
$cart = new cart("cart");
$cart->checkSession();
//////////////////////////////////////////////////////////

require_once("ifGETname.php");

$db->close();

/////HMJからとんできたレコメンドをソート/////////////
$name_arr = array();
$num = array();
foreach($mhj2 as $arr)
{
    foreach($arr as $key => $val)
    {
        if($key === "name")
        {
            if(!isset($num[$val])){$num[$val] = 0;};
            $num[$val] += 1; 
        }
    }
};
/////////////////////////////////////////////////////
/*
arsort($num);

echo "<pre>";
echo "昇順ソート <br/>";
var_dump($num);
echo "</pre>";
 */
//////////////////////////////////////////////////////

include_once('./html/detail.html');

?>
