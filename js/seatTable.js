
function changeBackgroundColor( id ){ <!-- 引数を変数idと変数colorに代入-->
    <!-- id属性の値が、変数idの値である要素の背景色を変更-->
    document . getElementById( id ) . style . backgroundColor = " #ff3000";
    <!-- mouseoutのときに背景色を#ff3000に戻す時ためにreserveiを追加 -->
    $("#"+id ).addClass("reserve");
}


