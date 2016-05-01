<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-04-28
 * Time: 오후 5:30
 */
//SeatTable
?>
<html>
<head>
<meta charset="utf-8" />
    <title>SeatTable</title>
    <style>
        .test {
            margin: 5px;
            padding: 50px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="js.js"></script>

</head>
<body>
<div style="width: 1300px; height: 123px;">
    <div style="float: left; margin-right: 30px; width: 600px; height: 120px;">
        <div>
            <div class="test mouseEvent"
                 style="float: left; background-color: greenyellow;  width: 90px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=7'">7
                <?php
                    $dbdata1 = 0; // StartTime
                    $dbdata2 = 0; // endTime
                ?>
            </div>
            <div class="test mouseEvent" style="float: left; background-color: greenyellow; width: 90px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=8'">8</div>
            <div class="test mouseEvent" style="float: left; background-color: greenyellow; width: 90px;"
                 onclick="location.href='http://localhost/aki_farm/Reserved.php?num=9'">9</div>
            <div style="clear: both;"></div>
        </div>
        <div>
            <div style="float: left; width: 50%;">
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=3'">3</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=2'">2</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=1'">1</div>
            </div>
            <div style="float: left; width: 50%;">
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=6'">6</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=5'">5</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 50px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=4'">4</div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
    <div style="float: left; width: 600px; height: 150px;">
        <div>
            <div style="float: left; width: 300px;">
                <div class="test mouseEvent" style="background-color: greenyellow; height: 25%;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=11'">11</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 25%;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=12'">12</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 25%;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=13'">13</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 25%;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=14'">14</div>
            </div>
            <div style="float: left; width: 300px;">
                <div class="test mouseEvent" style="background-color: greenyellow; height: 10px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=21'">21</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 10px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=22'">22</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 10px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=23'">23</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 10px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=24'">24</div>
                <div class="test mouseEvent" style="background-color: greenyellow; height: 10px;"
                     onclick="location.href='http://localhost/aki_farm/Reserved.php?num=25'">25</div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
    <div style="clear: both"></div>
</div>
</body>
</html>