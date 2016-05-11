<?php
/**
 * Created by PhpStorm.
 * User: SooJu</label>
 * Date: 2016-04-28
 * Time: 오후 4:45
 */

//予約ページ
/*
 *  ログイン処理
 *
 * 1. 4品の場合 AMPのページに渡す
 * 2. 4品以外の場合　→　ContentsCheck()
 * 3. ContentsCheck() RETURN False　→　RESERVEDに戻る
 * */
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>予約ページ</title>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="wrapper">
    <?php include_once('./common/header.html'); ?>
    <?php include_once('./common/nav.html'); ?>
    <h2>予約情報を入力してください。</h2>
    <form action="http://localhost:63342/aki_farm/aki_farm/confirm.php" method="post">
        <table border="1">
            <tr>
                <td>日にち</td>
                <td>
                    <input type="date" name="Date" />
                </td>
            </tr>
            <tr>
                <td>時刻</td>
                <td>
                    <select name="hour">
                        <option selected value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>時
                    <select name="minute">
                        <option selected value="00">00</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>分
                </td>
            </tr>
            <tr>
                <td>人数</td>
                <td>
                    <input type="number" name="peopleNum" class="unsigned" value="5" placeholder="5" />
                    <?php echo (isset($_GET['err']) ? $_GET['err'] : ""); ?>

                </td>
            </tr>
            <tr>
                <td>漢字名前</td>
                <td>
                    <input type="text" name="familyName" placeholder="FamilyName" value="張" />
                    <input type="text" name="firstName" placeholder="FirstName" value="秀朱" />
                </td>
            </tr>
            <tr>
                <td>ふりがな</td>
                <td>
                    <input type="text" name="familyName_kana" placeholder="FamilyName"  value="ジャン" />
                    <input type="text" name="firstName_kana" placeholder="FirstName"  value="スジュ" />
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <select name="phoneNum1">
                        <option selected value="080">080</option>
                        <option value="090">090</option>
                        <option value="070">070</option>
                    </select>-
                    <input type="number" name="phoneNum2" class="unsigned" placeholder="1234"  value="1234" />
                    <input type="number" name="phoneNum3" class="unsigned" placeholder="5555"  value="5555" />
                </td>
            </tr>
            <tr>
                <td>メール</td>
                <td>
                    <input type="text" name="mail" placeholder="abc@gmail.com" value="abc@gmail.com"  />
                </td>
            </tr>
            <tr>
                <td>コース名</td>
                <td>
                    <input type="radio" name="course" value="4" />4
                    <input type="radio" name="course" value="7" checked="checked" />7
                    <input type="radio" name="course" value="10" />10
                </td>
            </tr>
        </table>
        <input type="submit" name="send" value="予約" />
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>
