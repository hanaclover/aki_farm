var makeListFn = $(function()
{
  //--------オブジェクト宣言---------------------------------------------------------
  var arrHtml = new Array();
  var arrValue = new Array();
  var cart_arr = new Array();
  //cookie.jsの設定、魔法の言葉
  $.cookie.json = true;


  //--------リストをhtml出力するためのメソッド----------------------------------------------------------
  var makeHtmlList = function(arrValue){
    arrHtml.push(
      '<li>'
      + '<a href="detail.php?id=' + arrValue["id"] + '">'
      + '<img id="list" src="./img/' + arrValue["img"] + '" width="200" height="200" />'
      + '</a>'
      + '<button id="button' + arrValue["id"] + '">追加</button>'
      //+ '<p>' + arrValue["name"] + '</p>'
      + '</li>'
    );
  }


  //--------クッキーの更新を取得してカートの数字を書き換えるメソッド----------------------------------------------------------
  var cookieUpdate = function(){
    cart_arr = $.cookie('cart');
    if(!cart_arr) cart_arr=[];
    //カートの数字を書き換える
    $('.label').html(cart_arr.length);
  }


  //--------クッキーの更新を取得してカートの数字を書き換えるメソッド----------------------------------------------------------
  var initButton = function(){
    cart_arr = $.cookie('cart');
    if(!cart_arr) cart_arr=[];
    var counter = 0;
    while (counter<cart_arr.length) {
      $("#button" + cart_arr[counter]).html("削除");
      counter++;
    }
  }


  //--------配列の要素の数だけループし、html出力につなげるメソッド----------------------------------------------------------
  var listControl = function(target){
    for(var i=0 ; i < array.length ; i++){
      //makeHtmlListに配列を渡すために格納する処理。
      for(var cate in array[i]){
        arrValue[cate]=array[i][cate];
      }
      //allのときにはっ全部表示。検索ワードやカテゴリーソートの時は絞って表示
      if(target==="all"){
        makeHtmlList(arrValue);
      }else if (target == arrValue["category"] || arrValue["kana"].match(target)) {
        makeHtmlList(arrValue);
      }
    }
  }


  //--------ソートや検索が実行されたときのメソッド-----------------------------------------------------------
  var changeList = function(target){
    arrHtml = [];
    listControl($(target).val());
    changeHtml("#jsList");
  }


  //--------htmlを出力するメソッド-----------------------------------------------------------
  var changeHtml = function(target){
    $(target).html(arrHtml).hide().fadeIn(800);
    cookieUpdate();
  }

  //--------パブリックメソッド-----------------------------------------------------------

  //デフォルト（全表示）のhtmlを出力する
  listControl("all");
  changeHtml("#jsList");
  initButton();

  //selectの値を変更したときにメソッド発動
  $('[name=category]').change(function() {
    changeList('[name=category]');
  });

  //検索が実行されたときに実行する
  $('[type=button]').click(function(){
    if ($('[type=text]').val()) {
      changeList('[type=text]');
    }
  });
  $('[type=text]').keypress(function(e){
  	if ( e.which == 13 ) {
      if ($('[type=text]').val()) {
        changeList('[type=text]');
      }
  	}
  });

});
