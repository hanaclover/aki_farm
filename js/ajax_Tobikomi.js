/**
 * Created by Owner on 2016/05/13.
 */
$(function () {
    $("div.m5").click(function () {
        var sid = $(this).attr("id");
        // alert(sid);
        $.ajax(
            {
                type: "GET",
                url: "./ajax_Tobikomi.php",
                dataType: "html",
                data: {
                    sid: sid
                }
            }
        ).done(function(data) {
            alert(data);
            location.reload();
        });
    });
});