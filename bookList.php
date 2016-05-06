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
    <h1>
        本日の予約リスト
    </h1>
    <table border="1px" class="book">
        <tr>
            <th>
                お時間
            </th>
            <th>
                座席番号
            </th>
            <th>
                幹事様お名前
            </th>
            <th>
                電話番号
            </th>
            <th>
                編集
            </th>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
<!--                この書き方は一例だが、このようにリンクをGETで渡す-->
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr><tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
        <tr>
            <td>
                19:00
            </td>
            <td class="chairNum">
                <a href="bookList.php?chairNum=24">24</a>
            </td>
            <td>
                齊藤様
            </td>
            <td>
                090-1234-5678
            </td>
            <td class="edit">
                <input type="button" value="変更/削除">
            </td>
        </tr>
    </table>
</div>
</body>
</html>
