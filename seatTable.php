<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-04-28
 * Time: 오후 5:30
 */
//SeatTable

// DB連結
// 予約情報を
?>
<html>
<head>
<meta charset="utf-8" />
    <title>SeatTable</title>
    <style>
        .text-center {
            text-align: center;
        }
        .m5 {
            margin: 5px;
        }
        .left {
            float: left;
        }
        .both {
            clear: both;
        }
        .mr10 {
            margin-right: 10px;
        }
    </style>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <script src="js/confirm.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/seatTable.js"></script>
    <script src="js/ajax_Tobikomi.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tableForm.css" />
    <link rel="stylesheet" type="text/css" href="css/input.css" />
    <?php
    require_once "./class/ReserveModel.php";
    $reserveInfo = new ReserveModel();
    ?>
</head>
<body>
<div id="wrapper">
    <div style="margin: auto 0; width:830px;">
    <div>
        <input type="button" value="座席一覧" name="seat"
               onclick="location.href='http://localhost/aki_farm/seatTable.php?Date=<?php echo date("Y-m-d H:i:s") ?>'">
        <input type="button" value="予約一覧" name="reserve"
               onclick="location.href='http://localhost/aki_farm/bookList.php?Date=<?php echo date("Y-m-d") ?>'">
    </div>
    <div class="left mr10">

        <!-- 各ボタンを押すと
                1．席が埋まってるとき、2時間以内に予約が入ってるとき
                    - 各の予約情報が出る
                2．次の予約まで2時間以上の時、予約が入ってないとき
                    - 飛び込みで、今の時間から+2時間 して席を決める
         -->
        <div>
            <div id="7" class="left text-center m5 mouseEvent relative relative" style="background-color: greenyellow; width: 120px; height: 120px;" >7<p class="reserve_info"><?php echo $reserveInfo->getReserve(7)["msg"]; if($reserveInfo->getReserve(7)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(7);</script>";} ?></p></div>
            <div id="8" class="left text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 120px; height: 120px;"
                 >8<p class="reserve_info"><?php echo $reserveInfo->getReserve(8)["msg"]; if($reserveInfo->getReserve(8)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(8);</script>"; } ?></p></div>
            <div id="9" class="left text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 120px; height: 120px;"
                 >9<p class="reserve_info"><?php echo $reserveInfo->getReserve(9)["msg"]; if($reserveInfo->getReserve(9)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(9);</script>"; } ?></p></div>
            <div class="both"></div>
        </div>
        <div>
            <div class="left">
                <div id="3" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;" >3<p class="reserve_info"><?php echo $reserveInfo->getReserve(3)["msg"]; if($reserveInfo->getReserve(3)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(3);</script>"; } ?></p></div>
                <div id="2" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;" >2<p class="reserve_info"><?php echo $reserveInfo->getReserve(2)["msg"]; if($reserveInfo->getReserve(2)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(2);</script>"; } ?></p></div>
                <div id="1" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;" >1<p class="reserve_info"><?php echo $reserveInfo->getReserve(1)["msg"]; if($reserveInfo->getReserve(1)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(1);</script>"; } ?></p></div>
            </div>
            <div class="left">
                <div id="6" class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     >6<p class="reserve_info"><?php echo $reserveInfo->getReserve(6)["msg"]; if($reserveInfo->getReserve(6)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(6);</script>"; } ?></p></div>
                <div id="5" class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     >5<p class="reserve_info"><?php echo $reserveInfo->getReserve(5)["msg"]; if($reserveInfo->getReserve(5)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(5);</script>"; } ?></p></div>
                <div id="4" class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     >4<p class="reserve_info"><?php echo $reserveInfo->getReserve(4)["msg"]; if($reserveInfo->getReserve(4)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(4);</script>"; } ?></p></div>
            </div>
            <div class="both"></div>
        </div>
    </div>
    <div class="left">
        <div>
            <div class="left">
                <div id="10" class="text-center m5 mouseEvent relative relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     >11<p class="reserve_info"><?php echo $reserveInfo->getReserve(11)["msg"]; if($reserveInfo->getReserve(11)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(10);</script>"; } ?></p></div>
                <div id="11"class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     >12<p class="reserve_info"><?php echo $reserveInfo->getReserve(12)["msg"]; if($reserveInfo->getReserve(12)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(11);</script>"; } ?></p></div>
                <div id="12" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     >13<p class="reserve_info"><?php echo $reserveInfo->getReserve(13)["msg"];  if($reserveInfo->getReserve(13)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(12);</script>"; } ?></p></div>
                <div id="13" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     >14<p class="reserve_info"><?php echo $reserveInfo->getReserve(14)["msg"]; if($reserveInfo->getReserve(14)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(13);</script>"; } ?></p></div>
            </div>
            <div class="left">
                <div id="14" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     >21<p class="reserve_info"><?php echo $reserveInfo->getReserve(21)["msg"]; if($reserveInfo->getReserve(21)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(14);</script>";  }?></p></div>
                <div id="15" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     >23<p class="reserve_info"><?php echo $reserveInfo->getReserve(23)["msg"]; if($reserveInfo->getReserve(23)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(15);</script>"; } ?></p></div>
                <div id="16" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     >25<p class="reserve_info"><?php echo $reserveInfo->getReserve(25)["msg"]; if($reserveInfo->getReserve(25)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(16);</script>"; } ?></p></div>
                <div id="17" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     >27<p class="reserve_info"><?php echo $reserveInfo->getReserve(27)["msg"]; if($reserveInfo->getReserve(27)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(17);</script>"; } ?></p></div>
                <div id="18" class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     >30<p class="reserve_info"><?php echo $reserveInfo->getReserve(30)["msg"]; if($reserveInfo->getReserve(30)["flag"] == 1){ echo "<script language=\"javascript\">changeBackgroundColor(18);</script>"; } ?></p></div>
            </div>
            <div class="both"></div>
        </div>
    </div>
    <div class="both"></div>
    </div>
</div>
</body>
</html>
