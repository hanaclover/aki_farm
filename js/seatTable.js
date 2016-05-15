
function changeBackgroundColor( id ){ <!-- 引数を変数idと変数colorに代入-->
    document . getElementById( id ) . style . backgroundColor = " #ff3000"; <!-- id属性の値が、変数idの値である要素の背景色を変更-->
    $( id ).attr("name","reserve");
    var idname = $(this).attr("name"); 
    console.log(idname);
}


