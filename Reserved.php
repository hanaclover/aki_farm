<?php
/**
 * Created by PhpStorm.
 * User: SooJu</label>
 * Date: 2016-04-28
 * Time: 오후 4:45
 */

//予約ページ
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
    <form action="confirm.php" method="post">
        <table border="1">
            <tr>
                <td>日にち</td>
                <td>
                    <label>
                        <input type="date" name="Date"  />
                    </label>
                </td>
            </tr>
            <tr>
                <td>時刻</td>
                <td>
                    <label>
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
                    </label>
                </td>
            </tr>
            <tr>
                <td>人数</td>
                <td>
                    <label>
                        <input type="number" name="peopleNum" class="unsigned" />
                    </label>
                </td>
            </tr>
            <tr>
                <td>漢字名前</td>
                <td>
                    <input type="text" name="familyName" placeholder="FamilyName" />
                    <input type="text" name="firstName" placeholder="FirstName" />
                </td>
            </tr>
            <tr>
                <td>ふりがな</td>
                <td>
                    <input type="text" name="familyName_kana" placeholder="FamilyName" />
                    <input type="text" name="firstName_kana" placeholder="FirstName" />
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <label>
                        <select name="phoneNum1">
                            <option selected value="080">080</option>
                            <option value="090">090</option>
                            <option value="070">070</option>
                        </select>-
                        <input type="number" name="phoneNum2" class="unsigned" />
                        <input type="number" name="phoneNum3" class="unsigned" />
                    </label>
                </td>
            </tr>
            <tr>
                <td>メール</td>
                <td>
                    <label>
                        <input type="text" name="mail" />
                    </label>
                </td>
            </tr>
            <tr>
                <td>コース名</td>
                <td>
                    <label>
                        <input type="radio" name="course" value="4" />4
                        <input type="radio" name="course" value="7" />7
                        <input type="radio" name="course" value="10" />10
                    </label>
                </td>
            </tr>
        </table>
        <input type="submit" name="send" value="予約" />
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>
