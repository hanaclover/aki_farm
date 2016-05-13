/**
 * Created by Owner on 2016/05/11.
 */
$(function () {
    $("td select[name='minute'],td select[name='hour'],input[name='peopleNum'],input[name='Date']")
        .change(function () {
        // alert($("input[name='peopleNum']").val());
        // alert($("select[name='hour']").val()+":"+$("select[name='minute']").val()+":"+"00");
        // alert($("input[name='Date']").val());
        $.ajax(
            {
                type: "GET",
                url: "./ajaxReserve.php",
                dataType: "html",
                data: {
                    peopleNum: $("input[name='peopleNum']").val(),
                    StartDay: $("input[name='Date']").val(),
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