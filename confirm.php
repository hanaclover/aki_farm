<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/01
 * Time: 16:49
 */
?>
<html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/confirm.js"></script>
    <link rel="stylesheet" type="text/css" href="css/confirm.css">
    <!--<link rel="stylesheet" type="text/css" href="css/style.css"> -->
<title>
        ご予約内容のご確認
    </title>
</head>
<body>
<div id="wrapper">
 <?php //include_once('./common/header.html'); ?>
 <?php //include_once('./common/nav.html'); ?>
    <h1>
        以上の内容でよろしいですか？
    </h1>
    <form action="" method="post">
        <table class="confirm">
            <tr>
                <td>
                    来店日時
                </td>
                <td>
                    2016/04/28 19:00
                    <?php //echo $_POST["month"]."月".$_POST["day"]."日 ".$_POST["peopleNum"]."時".$_POST["minute"]."分"?>
                </td>
            </tr>
            <tr>
                <td>
                    人数
                </td>
                <td>
                    12
                </td>
            </tr>
            <tr>
                <td>
                    代表者氏名
                </td>
                <td>
                    山田　太郎乃助（やまだ　たろうのすけ）
                </td>
            </tr>
            <tr>
                <td>
                    電話番号
                </td>
                <td>
                    090-0909-0909
                </td>
            </tr>
            <tr>
                <td>
                    コース名
                </td>
                <td>
                    満腹プクプクコース
                </td>
            </tr>
            <tr>
                <td>
                    メールアドレス
                </td>
                <td>
                    MailAddress@send.co.jp
                </td>
            </tr>
        </table>
        <p class="btns">
            <span class="btn"><input type="submit" name="decide" value="確定" class="submit"></span>
            <span class="btn"><input type="submit" name="back" value="修正" class="modify"></span>
        </p>
        <p></p>
    </form>
</div>
 <?php //include_once('./common/footer.html'); ?>
</body>
</html>
