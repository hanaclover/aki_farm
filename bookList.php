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

    $_SESSION['stat'] = "Change";

    $pdo        = new PDODatabase();
    $date       = isset($_GET['Date']) ? $_GET['Date'] : date("Y-m-d");
    $SeatNum    = isset($_GET['SeatNum']) ? $_GET['SeatNum'] : 'All';
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
            $res = $pdo->select("user u, reserve r, seat s", "",
                                    " u.uid = r.UID and r.Del_flag = 0 and r.SID = s.SID
                                    and StartDay = ? and StartTime >= ?
                                    order by StartTime asc", $now);

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
                    if($data['Course_4'] !== '') {
                        $select4 = explode(",", $data['Course_4']);
                        for($i = 0; $i <= count($select4); $i++) {
                            if($i < 3)
                                echo $select4[$i].", ";
                            else
                                echo $select4[$i];
                        }
                    }
                echo "</td>";
                echo "<td class='edit'>
                        <input type='submit' name='send' value='変更/削除' />
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
                        <input type='submit' name='send' value='変更/削除' />
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
                        <input type='submit' name='send' value='変更/削除' />
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
                        <input type='submit' name='send' value='変更/削除' />
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
        // 今日の日付、現在の時間、すべての座席
        if($_date == date("Y-m-d") && $_SeatNum == '') {
            //初めて座席一覧のページに入ったとき　→　今日の日付、現在の時間、すべての座席
            return "Today";
        }  else if( $_date == date("Y-m-d") && $_SeatNum == 'All' ) {
            //今日の日付だけ選択　→　今日の日付、現在の時間、すべての座席
            return "Today";
        } else if( $_date == '' && $_SeatNum == 'All' ) {
            // 日付と座席番号を選択しない　→　今日の日付、現在の時間、すべての座席
            return "Today";
        }

        // 今日の日付、現在の時間、座席番号
        else if( $_date == date("Y-m-d") && $_SeatNum !== 'All' ) {
            // 今日の日付を選択、座席番号を選択　→　今日の日付、現在の時間、座席番号
            return "Now_Seat";
        } else if( $_date == '' && $_SeatNum !== 'All' ) {
            // 日付を選択しない、座席番号を選択　→　今日の日付、現在の時間、座席番号
            return "Now_Seat";
        }

        // 今日ではない特定の日を選択&座席番号を選択
        else if(($_date !== '' && $_date !== date("Y-m-d")) && $_SeatNum !== 'All' ) {
            return "SelectDay_Seat";
        }

        // 今日ではない特定の日を選択
        else if(($_date !== '' && $_date !== date("Y-m-d")) && $_SeatNum == 'All' ) {
            return "SelectDay";
        }
    }

    ?>
</div>
</body>
</html>
