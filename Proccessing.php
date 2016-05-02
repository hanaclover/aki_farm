<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-02
 * Time: 오후 12:50
 */
// 予約ペ?ジから?けたデ?タを?理


//DECIDEかBACKかを確認


//IF(DECIDE)の場合、
//データベースに保存 ->メールを送る -> complete.htmlに移動

if($_POST['confirm'] == "確定") {
    echo "<script>
        window.location.href = 'http://localhost/aki_farm/aki_farm/complete.html'; </script>";

} else if($_POST['confirm'] == "修正") {

    echo "<form action=>

    </form>";
}


//IF(BACK)の場合、
//POSTデ?タをそのままもって入力ペ?ジ(RESERVED)に?ります。

?>