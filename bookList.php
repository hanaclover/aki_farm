<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/04/28
 * Time: 18:31
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/booklist.js"></script>
    <link rel="stylesheet" type="text/css" href="css/booklist.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>
        予約一覧画面
    </title>
    <?php

    // db에서 정보 받아옴 (오늘의 예약 정보 전체를 받아옴)
    require_once "./class/PDODatabase.class.php";

    date_default_timezone_set("Asia/Tokyo");

    $pdo = new PDODatabase();
    $now = array(date("Y-m-d"), date("H:i:s"));

    ?>
</head>
<body>
<div id="wrapper">
    <div>
        <input type="button" value="座席一覧" name="seat"
               onclick="location.href='http://localhost/aki_farm/aki_farm/seatTable.php?Date=<?php echo date("Y-m-d H:i:s") ?>'">
        <input type="button" value="予約一覧" name="reserve"
               onclick="location.href='http://localhost/aki_farm/aki_farm/bookList.php?Date=<?php echo date("Y-m-d") ?>'">
    </div>
    <h1>
        本日の予約リスト
    </h1>
    <form action="" method="get">
        <input type='date' name='Date' />
        <?php
            $res = $pdo->select("seat", "", "", array());
            echo "<select name='SeatNum'>";
            echo "<option>All</option>";
            foreach($res as $data) {
                echo "<option>".$data['SNum']."</option>";
            }
            echo "</select>";
        ?>
        <input type="submit" name="Search" value="Search" />
    </form>
    <?php
    // 받아온 정보를 일단 리스트로 보여줌

    // 日付によって予約一覧を見せる
    echo "<table border=1px class='book'>";
    echo "<tr>
            <th>お時間</th>
            <th>座席番号</th>
            <th>幹事様お名前</th>
            <th>電話番号</th>
            <th>コース</th>
            <th>編集</th>
         </tr>";

    /*
     * 첨들어왔을땐 상관x
     *
     * 검색버튼을 눌렀을 때
     *  0. 처음 들어왔을 때
     *  0'. 오늘의 날짜 + 좌석
     *  1. 날짜는 없고, 좌석 번호만 1
     *  - 오늘의 날짜 + 해당 좌석 --- 현재시간 필요
     *  2. 날짜는 있고, 좌석 번호가 All 경우
     *  - 해당 날짜의 전체
     *  3. 둘 다 있는 경우 2016, 1
     *  - 해당날짜의 해당좌석
     *  - 오늘의 날짜 + 해당좌석 --- 현재시간 필요
     *  4. 둘다없는경우 - 첨 들어왔을때 (Date가 있을 때)
     *
     * */


    if(((isset($_GET['Date']) && $_GET['Date'] !== '') && !isset($_GET['SeatNum'])) ) {
        echo "case 0: Today's Reserve list, First in";
        // 걍 오늘꺼랑 똑같음
        // 1, 4번의 경우
        //$res = $pdo->select("user u, reserve r", "", " r.uid = u.uid and StartDay = ? order by case when r.StartTime >= ? then 1 else 2 end, r.StartTime + 0 asc", $now);
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime >= ? order by StartTime asc", $now);
        //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
        echo "<pre>";
        var_dump($res);
        echo "</pre>";
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td class='edit''><input type='button' value='変更/削除'></td>
                </tr>";
        }
        echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime <= ? ", $now);
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td></td>
                </tr>";
        }
    } else if((isset($_GET['Date']) && $_GET['Date'] == date("Y-m-d")) && (isset($_GET['SeatNum']) && $_GET['SeatNum'] !== 'All')) {
        echo "case 0': Today + SeatNum";

        $select = array($_GET['Date'], date("H:i:s"), $_GET['SeatNum']);
        //$res = $pdo->select("user u, reserve r", "", " r.uid = u.uid and StartDay = ? order by case when r.StartTime >= ? then 1 else 2 end, r.StartTime + 0 asc", $now);
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime >= ? order by StartTime asc", $select);
        //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td class='edit''><input type='button' value='変更/削除'></td>
                </tr>";
        }
        echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime <= ? and SID = ? ", $select);
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td></td>
                </tr>";
        }
    } else if((isset($_GET['Date']) && $_GET['Date'] == '') && (isset($_GET['SeatNum']) && $_GET['SeatNum'] !== 'All')) {
        echo "case 2: no Select Date & select SeatNum";
        // today, NowTime, SeatNum
        $select = array(date("Y-m-d"), date("H:i:s"), $_GET['SeatNum']);
        //$res = $pdo->select("user u, reserve r", "", " r.uid = u.uid and StartDay = ? order by case when r.StartTime >= ? then 1 else 2 end, r.StartTime + 0 asc", $now);
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime >= ? and SID = ? order by StartTime asc", $select);
        //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td class='edit''><input type='button' value='変更/削除'></td>
                </tr>";
        }
        echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime <= ? and SID = ? order by StartTime asc", $select);
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td></td>
                </tr>";
        }
    } else if((isset($_GET['Date']) && $_GET['Date'] !== '') && (isset($_GET['SeatNum']) && $_GET['SeatNum'] == 'All')) {
        echo "case 3: Select Date & SeatNum All";
        // Selected Date, NowTime, SeatNum
        $select = array($_GET['Date']);
        //$res = $pdo->select("user u, reserve r", "", " r.uid = u.uid and StartDay = ? order by case when r.StartTime >= ? then 1 else 2 end, r.StartTime + 0 asc", $now);
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? order by StartTime asc", $select);
        //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td class='edit''><input type='button' value='変更/削除'></td>
                </tr>";
        }
        /*echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
        $res = $pdo->select("user u, reserve r", "", " StartDay = ? order by StartTime asc", $select);
        foreach($res as $data) {
            echo "<tr>
                    <td>".$data['StartDay']." ".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SID']."'>".$data['SID']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td></td>
                </tr>";
        }*/
    } else if((isset($_GET['Date']) && $_GET['Date'] !== '') && (isset($_GET['SeatNum']) && $_GET['SeatNum'] !== 'All')) {
        echo "case 4: Select Date & Select SeatNum";
    }
    echo "</table>";
    ?>
</div>
</body>
</html>
