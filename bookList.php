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
</head>
<body>
<div id="wrapper">
    <div>
        <input type="button" value="座席一覧" name="seat"
               onclick="location.href='http://localhost/aki_farm/aki_farm/seatTable.php?today=<?php echo date("Y-m-d H:i:s") ?>'">
        <input type="button" value="予約一覧" name="reserve"
               onclick="location.href='http://localhost/aki_farm/aki_farm/bookList.php?today=<?php echo date("Y-m-d") ?>'">
    </div>
    <h1>
        本日の予約リスト
    </h1>
    <?php

    // db에서 정보 받아옴 (오늘의 예약 정보 전체를 받아옴)
    require_once "./class/PDODatabase.class.php";

    $pdo = new PDODatabase();
    //SELECT * FROM `reserve`   where StartDay = CURRENT_DATE and StartTime >= CURRENT_TIME
    $arr = array(date("Y-m-d"), date("H:i:s"));
    $res = $pdo->select("reserve", "", "StartDay = ? and StartTime >= ?", $arr);
    // 받아온 정보를 일단 리스트로 보여줌

    $pdo->setQuery("select * ");

    // 日付によって予約一覧を見せる
    echo "<table border=1px class='book'>";
    echo "<tr>
            <th>お時間</th>
            <th>座席番号</th>
            <th>幹事様お名前</th>
            <th>電話番号</th>
            <th>編集</th>
         </tr>";
    foreach($res as $data) {
        echo "<tr>
                <td>".$data['StartDay']."</td>
                <td class='chairNum'>
                    <a href='bookList.php?chairNum=".$data['PeopleNum']."'>".$data['PeopleNum']."</a>
                </td>
                <td>
                    齊藤様
                </td>
                <td>
                    090-1234-5678
                </td>
                <td class='edit''>
                    <input type='button'' value='変更/削除'>
                </td>
            </tr>";
    }
    echo "</table>";
    ?>
</div>
</body>
</html>
