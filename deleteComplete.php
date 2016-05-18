<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-17
 * Time: 오전 10:47
 */
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/confirm.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include_once('./common/header.html'); ?>
    <?php include_once('./common/nav.html'); ?>
    <?php

    if($_GET['confirm'] == "変更") {
        echo "<h1>予約内容を変更しました。</h1>";
    } else if($_SESSION['stat'] == "Change") {
        echo "<h1>削除が成功しました。</h1>";
    }
    ?>
    <form action="./bookList.php" method="post">
        <input type="submit" name="Home" class="common_btn"/>
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>

