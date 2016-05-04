/**
 * Created by Owner on 2016/05/01.
 */
$(function () {
    //hover関数は2つの引数を持つ
    $("input.sub").hover(function () {
       $(this).css("cursor" , "pointer");
    } , function () {
       $(this).css("cursor" , "default");
    });
    $(".confirm tr").mouseover(function () {
        $("tr:nth-child("+(($("tr").index(this))+1)+") td").addClass("hover");
    }).mouseout(function () {
        $("tr:nth-child("+(($("tr").index(this))+1)+") td").removeClass("hover");
    });
});
