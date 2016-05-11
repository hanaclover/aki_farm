/**
 * Created by Owner on 2016/05/01.
 */
$(function () {
    //マウスを乗せるとカーソルの形が変わる
    // hover関数は2つの引数を持つ
    $("input.common_btn").hover(function () {
       $(this).css("cursor" , "pointer");
    } , function () {
       $(this).css("cursor" , "default");
    });
    //マウスが乗っている列の全てのセルにhoverクラス属性を与える
    $(".confirm tr").mouseover(function () {
        $("tr:nth-child("+(($("tr").index(this))+1)+") td").addClass("hover");
    }).mouseout(function () {
        $("tr:nth-child("+(($("tr").index(this))+1)+") td").removeClass("hover");
    });
});
