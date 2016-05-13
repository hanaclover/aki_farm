<?php

    $name = $_GET["name"];
    $ctr  = new control(db_host, db_user, db_pass, db_name );
    $data = $ctr->detailOpen($name);

/*
if($_GET["sort"] == "add" && $_SESSION["cart"] !== array() ){
	$data = $ctr->addSelect($_SESSION["cart"]);
}elseif($_GET["sort"] == "add" && $_SESSION["cart"] == array() ){
	echo "not selected!!!";
	$data = $ctr->allSelect();
}elseif(($_GET["sort"] !== "all") && $_GET["sort"] !== "" ){
	$data = $ctr->categorySort($_GET["sort"]);
}elseif($_GET["searchword"] !== "" ){
	$data = $ctr->wordSearch($_GET["searchword"]);
}else{ */
?>
