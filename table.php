<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-19
 * Time: 오전 10:08
 */
?>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Table</title>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <script src="js/confirm.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/seatTable.js"></script>
    <script src="js/ajax_Tobikomi.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tableForm.css" />
    <link rel="stylesheet" type="text/css" href="css/input.css" />
    <!--<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tableForm.css" />
    <link rel="stylesheet" type="text/css" href="css/input.css" />-->
    <?php
    require_once "./class/ReserveModel.php";
    $reserveInfo = new ReserveModel();
    ?>
    <style>
        .m5 {
            margin: 5px;
        }
        .color {
            background-color: #ff9999;
        }
    </style>
</head>
<body>
    <div style="width: 1500px;" >
        <div class="" style="float: left;">
            <div>
                <div id="3" class="color left text-center m5 mous eEvent relative" style="float: left; width: 200px; height: 220px;" >3<p class="reserve_info"><?php echo $reserveInfo->getReserve(3)["msg"]; if($reserveInfo->getReserve(3)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(3);</script>";} ?></p></div>
                <div id="4"  class="color left text-center m5 mous eEvent relative" style="float: left; width: 200px; height: 220px;" >4<p class="reserve_info"><?php echo $reserveInfo->getReserve(4)["msg"]; if($reserveInfo->getReserve(4)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(4);</script>";} ?></p></div>
            </div>
            <div style="clear: both"></div>
            <div>
                <div id="1"  class="color left text-center m5 mouseEvent relative"  style="float: left;width: 200px; height: 220px;">1<p class="reserve_info"><?php echo $reserveInfo->getReserve(1)["msg"]; if($reserveInfo->getReserve(1)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(1);</script>";} ?></p></div>
                <div id="2"  class="color left text-center m5 mous eEvent relative" style="float: left;width: 200px; height: 220px;">2<p class="reserve_info"><?php echo $reserveInfo->getReserve(2)["msg"]; if($reserveInfo->getReserve(2)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(2);</script>";} ?></p></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="" style="float: left;">
            <div>
                <div id="7" class="color left text-center m5 mous eEvent relative" style="float: left;width: 200px; height: 180px;">7<p class="reserve_info"><?php echo $reserveInfo->getReserve(7)["msg"]; if($reserveInfo->getReserve(7)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(7);</script>";} ?></p></div>
                <div id="8" class="color left text-center m5 mous eEvent relative" style="float: left;width: 200px; height: 180px;">8<p class="reserve_info"><?php echo $reserveInfo->getReserve(8)["msg"]; if($reserveInfo->getReserve(8)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(8);</script>";} ?></p></div>
                <div id="9" class="color left text-center m5 mous eEvent relative" style="float: left;width: 200px; height: 180px;">9<p class="reserve_info"><?php echo $reserveInfo->getReserve(9)["msg"]; if($reserveInfo->getReserve(9)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(9);</script>";} ?></p></div>
            </div>
            <div>
                <div id="5" class="color left text-center m5 mous eEvent relative"  style="float: left;width: 300px; height: 130px;">5<p class="reserve_info"><?php echo $reserveInfo->getReserve(5)["msg"]; if($reserveInfo->getReserve(5)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(5);</script>";} ?></p></div>
                <div id="6" class="color left text-center m5 mous eEvent relative"  style="float: left;width: 300px; height: 130px;">6<p class="reserve_info"><?php echo $reserveInfo->getReserve(6)["msg"]; if($reserveInfo->getReserve(6)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(6);</script>";} ?></p></div>
                <div style="clear: both"></div>
                <div id="15" class="color left text-center m5 mous eEvent relative"  style="float: left;width: 300px; height: 130px;">15<p class="reserve_info"><?php echo $reserveInfo->getReserve(15)["msg"]; if($reserveInfo->getReserve(4)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(15);</script>";} ?></p></div>
                <div id="14" class="color left text-center m5 mous eEvent relative"  style="float: left;width: 300px; height: 130px;">14<p class="reserve_info"><?php echo $reserveInfo->getReserve(14)["msg"]; if($reserveInfo->getReserve(14)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(14);</script>";} ?></p></div>
            </div>
        </div>
        <div class="" style="float: left;">
            <div>
                <div id="10" class="color left text-center m5 mous eEvent relative"  style="width: 200px; height: 110px;">10<p class="reserve_info"><?php echo $reserveInfo->getReserve(10)["msg"]; if($reserveInfo->getReserve(10)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(10);</script>";} ?></p></div>
                <div id="11" class="color left text-center m5 mous eEvent relative"  style="width: 200px; height: 110px;">11<p class="reserve_info"><?php echo $reserveInfo->getReserve(11)["msg"]; if($reserveInfo->getReserve(11)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(11);</script>";} ?></p></div>
                <div id="12" class="color left text-center m5 mous eEvent relative"  style="width: 200px; height: 110px;">12<p class="reserve_info"><?php echo $reserveInfo->getReserve(12)["msg"]; if($reserveInfo->getReserve(12)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(12);</script>";} ?></p></div>
                <div id="13" class="color color left text-center m5 mous eEvent relative"  style="width: 200px; height: 110px;">13<p class="reserve_info"><?php echo $reserveInfo->getReserve(4)["msg"]; if($reserveInfo->getReserve(13)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(13);</script>";} ?></p></div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
</body>
</html>
