/**
 * Created by Owner on 2016/05/11.
 */
$(function () {
    $("td select[name='minute']").change(function () {
        
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