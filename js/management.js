/**
 * Created by SooJu on 2016-05-01.
 */
$(document).ready(function(){
    $('.mouseEvent').mouseover(function(){
        $(this).css("backgroundColor","#ccc");
    });
    $('.mouseEvent').mouseout(function(){
        if($('.reserve').length) {
            console.log($(this));
            $(this).css("backgroundColor","yellow");
        } else {
            $(this).css("backgroundColor","greenyellow");
        }
    });

    $(".unsigned").change(function() {
        var num = $(this).val();
        if(typeof num !== "number" || num <= 0) {
            // alert("正数だけお願いいたします。");
            
            $(this).focus();
            return false;
        }
    });
});


