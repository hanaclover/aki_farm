/**
 * Created by SooJu on 2016-05-01.
 */
$(document).ready(function(){
    $('.mouseEvent').mouseover(function(){
        $(this).css("backgroundColor","#ccc");
    });
    $('.mouseEvent').mouseout(function(){
        $(this).css("backgroundColor","greenyellow");
    });

    $(".unsigned").change(function() {
        var num = $(this).val() - 1;
        if(typeof num !== "number" || num < 0) {
            alert("正数だけお願いいたします。");
            $(this).focus();
            return false;
        }
    });
});


