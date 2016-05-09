$(function(){
    //カーソルがある列のヘッダーをハイライトするコード
    $(".book td").mouseover(function () {
        $("th:nth-child("+($("td").index(this)%$("th").length+1)+")").addClass("hover");
    }).mouseout(function () {
        $("th:nth-child("+($("td").index(this)%$("th").length+1)+")").removeClass("hover");
    });
    //送信ボタンにマウスを乗せたときにカーソルの形を変えるコード
    $(".edit input").hover(function () {
        $(this).css("cursor" , "pointer");
    } , function () {
        $(this).css("cursor" , "default");
    });
});