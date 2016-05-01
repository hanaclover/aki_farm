$(function(){
    $(".book td").mouseover(function () {
        $("th:nth-child("+($("td").index(this)%$("th").length+1)+")").addClass("hover");
    }).mouseout(function () {
        $("th:nth-child("+($("td").index(this)%$("th").length+1)+")").removeClass("hover");
    })
});