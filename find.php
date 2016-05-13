<?php


$term = strip_tags(substr($_POST['search_term'],0, 100));

//$term = "t";

//////default settings/////////////////
require_once("config.php");
require_once("./class/dbClass.php");
require_once("./class/listControlClass.php");
require_once("./class/jsClass.php");
//////////////////////////////////////

///////////call classes///////////////////////////////////
$ctr = new control(db_host, db_user, db_pass, db_name );
//////////////////////////////////////////////////////////

$data = $ctr->incrementSearch($term);
$string = "";
//print_r($data);

foreach($data as $arr)
{
    foreach($arr as $val)
    {
        $string = $string."'". $val. "'". ", ";
    }
};

//print_r($string);

echo ($string);

?>
