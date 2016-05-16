/**
 * Created by Owner on 2016/05/11.
 */
$(function () {
    $("td select[name='minute'],td select[name='hour'],input[name='peopleNum'],input[name='Date']")
        .keyup(function () {
            $(this).change();
        }).change(function () {
        // alert($("input[name='peopleNum']").val());
        // alert($("select[name='hour']").val()+":"+$("select[name='minute']").val()+":"+"00");
        // alert($("input[name='Date']").val());
        var userDate=$("input[name='Date']").val();
        $.ajax(
            {
                type: "GET",
                url: "./ajaxReserve.php",
                dataType: "html",
                data: {
                    peopleNum: $("input[name='peopleNum']").val(),
                    StartDay: userDate,
                    startTime: $("select[name='hour']").val()+":"+$("select[name='minute']").val()+":"+"00"
                }
            }
        ).done(function(data) {
            if (data != null && data.length > 10) {
                $("#shimaiten").html(data + "<p><a href='http://meijin-farm.com/welcome/'>Meijin農場</a></p>");
            }else{
                $("#shimaiten").empty();
            }
        });
        //文字列からミリ秒を取得
        var time = Date.parse(userDate);
        var selDate = new Date();
        selDate.setTime(time);
        var today = new Date();
        if ((today.getTime()-1000*60*60*24) > selDate.getTime()){
            $(".datemsg").text("日付は今日以降のものを入力してください");
            var text = today.getFullYear()  + "-" +
                (("0" + (today.getMonth() + 1)).slice(-2)) + "-" + (("0" + today.getDate()).slice(-2));
            alert(text);
            $("input[name='Date']").val(text);
        }else{
            $(".datemsg").text("");
        }
    }).keyup(function () {
        $(this).change();
    });
   $("tr:nth-child(100)").hover(function () {
       // $(".space").load("./try.php");
       $.ajax(
           {
               type: "GET",
               url: "./try.php",
               dataType: "html",
               success: function (data) {
                   $(".space").html($(data).text());
               }
           }
       );
   },function () {

   });
});