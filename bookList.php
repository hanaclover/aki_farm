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

    require_once "./class/PDODatabase.class.php";

    date_default_timezone_set("Asia/Tokyo");

    $pdo = new PDODatabase();

    $date       = isset($_GET['Date']) ? $_GET['Date'] : '';
    $SeatNum    = isset($_GET['SeatNum']) ? $_GET['SeatNum'] : '';
    ?>
</head>
<body>
<div id="bl_wrapper">
    <div>
        <input type="button" value="座席一覧" name="seat"
               onclick="location.href='./seatTable.php?Date=<?php echo date("Y-m-d H:i:s") ?>'">
        <input type="button" value="予約一覧" name="reserve"
               onclick="location.href='./bookList.php?Date=<?php echo date("Y-m-d") ?>'">
    </div>
    <h1>
        本日の予約リスト
    </h1>
    <form action="" method="get">
        <input type='date' name='Date' />
        <?php
            $res = $pdo->select("seat", "", "", array());
            echo "<select name='SeatNum'>
                    <option>All</option>";
            foreach($res as $data) {
                echo "<option>".$data['SNum']."</option>";
            }
            echo "</select>";
        ?>
        <input type="submit" name="Search" value="Search" />
    </form><br />
    <?php
    // 日付によって予約一覧を見せる
    echo "<table border=1px class='book'>";
    echo "<tr>
            <th>お時間</th>
            <th>座席番号</th>
            <th>幹事様お名前</th>
            <th>人数</th>
            <th>電話番号</th>
            <th>コース</th>
            <th>備考</th>
            <th>編集</th>
         </tr>";

    switch($InputCase = CasebyInput($date, $SeatNum)) {
        case "Today" :
            // $now = array(date("Y-m-d"), date("H:i:s"));
            // StartDay = ? and StartTime >= ? order by StartTime asc
            $now = array(date("Y-m-d"), date("H:i:s"));
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? and StartTime >= ? order by StartTime asc", $now);
            foreach($res as $data) {
                echo "<form action='./changeReserved.php' method='GET'>";
                echo "<tr>
                        <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                        <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                        <td>".$data['FamilyName']." ".$data['FirstName'].$data['UID']."</td>
                        <td>".$data['PeopleNum']."</td>
                        <td>".$data['PhoneNum']."</td>
                        <td>".$data['Course']."</td>";
                echo "<td>";
                    $select4 = explode(",", $data['Course_4']);
                    for($i = 0; $i <= count($select4); $i++) {
                        if($i < 3)
                            echo $select4[$i].", ";
                        else
                            echo $select4[$i];
                    }
                echo "</td>";
                echo "<td class='edit'>
                        <input type='submit' name='change' value='変更/削除' />
                        <input type='hidden' name='RID' value='".$data['RID']."' />
                        <input type='hidden' name='UID' value='".$data['UID']."' />
                      </td>
                      </tr>";
                echo "</form>";
            }
            echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? and StartTime <= ? ", $now);
            foreach($res as $data) {
                echo "<tr>
                    <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName'].$data['UID']."</td>
                    <td>".$data['PeopleNum']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td>".$data['Course_4']."</td>
                    <td></td>
                </tr>";
            }
            break;
        case "Now_Seat" :
            // $now = array(date("Y-m-d"), date("H:i:s"));
            // StartDay = ? and StartTime >= ? order by StartTime asc
            $select = array(date("Y-m-d"), date("H:i:s"), $SeatNum);
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? and StartTime >= ? and SNum = ? order by StartTime asc", $select);
            //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
            foreach($res as $data) {
                echo "<form action='./changeReserved.php' method='GET'>";
                echo "<tr>
                    <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PeopleNum']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td>".$data['Course_4']."</td>
                    <td class='edit'>
                        <input type='submit' name='change' value='変更/削除' />
                        <input type='hidden' name='RID' value='".$data['RID']."' />
                        <input type='hidden' name='UID' value='".$data['UID']."' />
                    </td>
                </tr>";
                echo "</form>";
            }
            echo "<tr style='background-color: #777777'>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
            //$res = $pdo->select("user u, reserve r", "", " StartDay = ? and StartTime >= ? and SID = ? order by StartTime asc", $select);
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? and StartTime <= ? and SNum = ? order by StartTime asc", $select);
            foreach($res as $data) {
                echo "<tr>
                    <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PeopleNum']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td>".$data['Course_4']."</td>
                    <td></td>
                </tr>";
            }
            break;
        case "SelectDay" :
            // Selected Date
            $select = array($date);
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? order by StartTime asc", $select);
            //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
            foreach($res as $data) {
                echo "<form action='./changeReserved.php' method='GET'>";
                echo "<tr>
                    <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PeopleNum']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td>".$data['Course_4']."</td>
                    <td class='edit'>
                        <input type='submit' name='change' value='変更/削除' />
                        <input type='hidden' name='RID' value='".$data['RID']."' />
                        <input type='hidden' name='UID' value='".$data['UID']."' />
                    </td>
                </tr>";
                echo "</form>";
            }
            break;
        case "SelectDay_Seat" :
            $select = array($date, $SeatNum);
            //date("Y-m-d"), date("H:i:s")
            $res = $pdo->select("user u, reserve r, seat s", "", " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID and StartDay = ? and SNum = ? order by StartTime asc", $select);
            //select * from reserve r, user u where StartDay = CURRENT_DATE order by case when StartTime >= CURRENT_TIME then 1 else 2 end, StartTime + 0 asc
            foreach($res as $data) {
                echo "<form action='./changeReserved.php' method='GET'>";
                echo "<tr>
                    <td>".$data['StartDay']."<br>".$data['StartTime']."</td>
                    <td class='chairNum'><a href='bookList.php?chairNum=".$data['SNum']."'>".$data['SNum']."</a></td>
                    <td>".$data['FamilyName']." ".$data['FirstName']."</td>
                    <td>".$data['PeopleNum']."</td>
                    <td>".$data['PhoneNum']."</td>
                    <td>".$data['Course']."</td>
                    <td>".$data['Course_4']."</td>
                    <td class='edit'>
                        <input type='submit' name='change' value='変更/削除' />
                        <input type='hidden' name='RID' value='".$data['RID']."' />
                        <input type='hidden' name='UID' value='".$data['UID']."' />
                    </td>
                </tr>";
                echo "</form>";
            }
            break;
    }
    echo "</table>";


    function CasebyInput($_date, $_SeatNum) {
        // 오늘 날짜인 경우 + 모든 좌석
        if($_date == date("Y-m-d") && $_SeatNum == '') {
            // 첨 들어왔을때 날짜가 오늘 날짜, 좌석없음 -> 모든좌석 & 오늘날짜 + 현재시간
            // $now = array(date("Y-m-d"), date("H:i:s"));
            // StartDay = ? and StartTime >= ? order by StartTime asc
            return "Today";
        }  else if( $_date == date("Y-m-d") && $_SeatNum == 'All' ) {
            // 오늘 날짜만 선택 후 검색 -> 모든 좌석 & 오늘날짜 + 현재시간
            return "Today";
        } else if( $_date == '' && $_SeatNum == 'All' ) {
            // 오늘 날짜, 좌석 선택 -> 모든 좌석 & 오늘날짜 + 현재시간
            // StartDay = ? and StartTime >= ? order by StartTime asc
            return "Today";
        }

        // 오늘 날짜 + 해당 좌석
        else if( $_date == date("Y-m-d") && $_SeatNum !== 'All' ) {
            // 오늘 날짜 선택, 좌석 선태 -> 해당 좌석 & 오늘날짜 + 현재시간
            // $select = array("$date", "date("H:i:s")", "$SeatNum");
            // StartDay = ? and StartTime >= ? SID = ? order by StartTime asc
            return "Now_Seat";
        } else if( $_date == '' && $_SeatNum !== 'All' ) {
            // 오늘 날짜, 좌석 선택 -> 해당 좌석 & 오늘날짜 + 현재시간
            // StartDay = ? and StartTime >= ? SID = ? order by StartTime asc
            return "Now_Seat";
        }

        // 날짜 선택
        else if(($_date !== '' && $_date !== date("Y-m-d")) && $_SeatNum !== 'All' ) {
            // 다른 날짜, 좌석을 선택 -> 해당 좌석 & 해당 날짜
            // $select = array("$date", "$SeatNum");
            // StartDay = ? and SID = ? order by StartTime asc
            return "SelectDay_Seat";
        }

        else if(($_date !== '' && $_date !== date("Y-m-d")) && $_SeatNum == 'All' ) {
            // 다른 날짜 -> 전체 좌석 & 해당 날짜
            // $select = array("$date");
            // StartDay = ? order by StartTime asc
            return "SelectDay";
        }
    }

    ?>
</div>
</body>
</html>
