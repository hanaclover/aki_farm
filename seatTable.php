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
               onclick="location.href='./seatTable.php?Date=<?php echo date("Y-m-d H:i:s") ?>'">
        <input type="button" value="予約一覧" name="reserve"
               onclick="location.href='./bookList.php?Date=<?php echo date("Y-m-d") ?>'">
    </div>
    <div class="left mr10">

        <!-- 各ボタンを押すと
                1．席が埋まってるとき、2時間以内に予約が入ってるとき
                    - 各の予約情報が出る
                2．次の予約まで2時間以上の時、予約が入ってないとき
                    - 飛び込みで、今の時間から+2時間 して席を決める
         -->
        <div>
            <div class="left text-center m5 mouseEvent relative relative" style="background-color: greenyellow; width: 120px; height: 120px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=7'">7<p class="reserve_info"><?php echo $reserveInfo->getReserve(7) ?></p></div>
            <div class="left text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 120px; height: 120px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=8'">8<p class="reserve_info"><?php echo $reserveInfo->getReserve(8) ?></p></div>
            <div class="left text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 120px; height: 120px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=9'">9<p class="reserve_info"><?php echo $reserveInfo->getReserve(9) ?></p></div>
            <div class="both"></div>
        </div>
        <div>
            <div class="left">
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=3'">3<p class="reserve_info"><?php echo $reserveInfo->getReserve(3) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=2'">2<p class="reserve_info"><?php echo $reserveInfo->getReserve(2) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=1'">1<p class="reserve_info"><?php echo $reserveInfo->getReserve(1) ?></p></div>
            </div>
            <div class="left">
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=6'">6<p class="reserve_info"><?php echo $reserveInfo->getReserve(6) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=5'">5<p class="reserve_info"><?php echo $reserveInfo->getReserve(5) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow;  width: 185px; height: 105px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=4'">4<p class="reserve_info"><?php echo $reserveInfo->getReserve(4) ?></p></div>
            </div>
            <div class="both"></div>
        </div>
    </div>
    <div class="left">
        <div>
            <div class="left">
                <div class="text-center m5 mouseEvent relative relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=11'">11<p class="reserve_info"><?php echo $reserveInfo->getReserve(11) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=12'">12<p class="reserve_info"><?php echo $reserveInfo->getReserve(12) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=13'">13<p class="reserve_info"><?php echo $reserveInfo->getReserve(13) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=14'">14<p class="reserve_info"><?php echo $reserveInfo->getReserve(14) ?></p></div>
            </div>
            <div class="left">
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=21'">21<p class="reserve_info"><?php echo $reserveInfo->getReserve(21) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=22'">23<p class="reserve_info"><?php echo $reserveInfo->getReserve(23) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=23'">25<p class="reserve_info"><?php echo $reserveInfo->getReserve(25) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 82px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=24'">27<p class="reserve_info"><?php echo $reserveInfo->getReserve(27) ?></p></div>
                <div class="text-center m5 mouseEvent relative" style="background-color: greenyellow; width: 150px; height: 110px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=25'">30<p class="reserve_info"><?php echo $reserveInfo->getReserve(30) ?></p></div>
            </div>
            <div class="both"></div>
        </div>
    </div>
    <div class="both"></div>
    </div>
</div>
</body>
</html>
