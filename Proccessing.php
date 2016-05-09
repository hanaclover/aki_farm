<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-02
 * Time: 오후 12:50
 */
// 予約ペ?ジから?けたデ?タを?理

//確定か修正かを確認

//IF(確定)の場合、
//データベースに保存 ->メールを送る -> complete.htmlに移動

if($_POST['confirm'] == "確定") {
    echo "<script>
        window.location.href = 'http://localhost/aki_farm/aki_farm/complete.html'; </script>";

} else if($_POST['confirm'] == "修正") {

   /*echo  "<form action='Reserved.php' method='post'>
        <input type='hidden' name='Date' value=".$_POST['Date']." />
        <input type='hidden' name='hour' value=".$_POST['hour']." />
        <input type='hidden' name='minute' value=".$_POST['minute']." />
        <input type='hidden' name='peopleNum' value=".$_POST['peopleNum']." />
        <input type='hidden' name='familyName' value=".$_POST['familyName']." />
        <input type='hidden' name='firstName' value=".$_POST['firstName']." />
        <input type='hidden' name='familyName_kana' value=".$_POST['familyName_kana']." />
        <input type='hidden' name='firstName_kana' value=".$_POST['firstName_kana']." />
        <input type='hidden' name='phoneNum1' value=".$_POST['phoneNum1']." />
        <input type='hidden' name='phoneNum2' value=".$_POST['phoneNum2']." />
        <input type='hidden' name='phoneNum3' value=".$_POST['phoneNum3']." />
        <input type='hidden' name='mail' value=".$_POST['mail']." />
        <input type='hidden' name='course' value=".$_POST['course']." />
    </form>" ;*/

}


//IF(BACK)の場合、
//POSTデ?タをそのままもって入力ペ?ジ(RESERVED)に?ります。

?>