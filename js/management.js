/**
 * Created by SooJu on 2016-05-01.
 */
$(document).ready(function(){
    <!-- マウスオーバーした時背景色を変更 -->
    $('.mouseEvent').mouseover(function(){
        $(this).css("backgroundColor","#ccc");
    });
    <!-- マウスアウトした時に背景色を戻す -->
    $('.mouseEvent').mouseout(function(){
        <!-- .reserveが付与されている時は背景色を#ff3000無いときはgreenyellowに変更する -->
        if($(this).hasClass('reserve')) {
            $(this).css("backgroundColor","#ff3000");
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


