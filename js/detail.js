//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<[$()ここから]>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$(function()
{
//-------もろもろ作成-------------------------------------------------------
    $('div#res').append('<a id="res" href="reserve.php">Go cart!!</a>');
    $.cookie.json = true;
    var cart_arr = $.cookie('cart');
    if( !cart_arr )
    {
        cart_arr = Array();
    };

//--------詳細を表示------------------------------------------------------------
    var arrctg = new Array();
    for(var i=0 ; i < array.length ; i++)
    {	
		for(var y in array[i])
        {
            //imgのみタグつきで書き込む
            //console.log(cart_arr);
            if( y === "img")
            {
                var name_d = array[i][y].substr(0, array[i][y].length-4);
                listMakeDel(arrctg, array[i][y], name_d);
            } 
            /*else if( y === "kana" )
            {
                arrctg.push('<p class="' + y + '">' + array[i][y] + ' </p>' 
                + ' <p><button type="button" id="' + 
                array[i][y] + '" class="del">削除</button></p> ');
            }*/
            else if( y === "name" || y === "detail" || y === "price" )
            {
                arrctg.push("<p class='" + y + "'>" + array[i][y] + " </p> ");
            }
        }
    };
    
    $("div#box").html(arrctg);		    

//------乱数作るって適当に引っ張ってくる--------------------------------------------------------------------

//------カートに追加・削除----------------------------------------------------------------------------------
    $('button').on("click", function()
        {
            console.log("a");
            if($(this).attr("class") === "add")
            {
                addButton((this));
            }
            else if($(this).attr("class") === "del")
            {
                delButton((this));
            }/*
            else if($(this).attr("id") === "res")
            {
                window.location.href = 'reserve.php'
            }*/
        });

    function addButton(that)
    {
        var flg = $(that).attr('id'); 
        if(cart_arr == null)
        {
            cart_arr = $.cookie('cart');
        }
        else if(cart_arr.indexOf(flg) !=-1)
        {
            alert('既に登録されています');
        }
        else  if(cart_arr.length > 3)
        {
            alert('cart max!!');
        }
        else
        {
            console.log("a");
            cart_arr.push(flg);    
            $(that).attr("class", "del"); 
            $(that).text("削除");
        };
    $.cookie('cart', cart_arr);
    };

    function delButton(that)
    {
        var flg    = $(that).attr('id'); 
        //flgReg = new RegExp(flg);
        //console.log(typeof $.cookie('cart'));
        if(cart_arr == null)
        {
            cart_arr = $.cookie('cart');
        }
        else
        {
            console.log("d");
            cart_arr.some(function(v, i)
            {
                if (v==flg) cart_arr.splice(i,1);    
            });
        $(that).attr("class", "add"); 
        $(that).text("追加");
        };
        $.cookie('cart', cart_arr);
    };

    function listMakeAdd(arrctg, arr, name )
    {
        arrctg.push('<p><img id="list"  src="./img/' + 
        arr + '" width="200" height="200" /></a></p> <p><button type="button" id="' + 
        name + '" class="add">追加</button></p> ');
    };

    function listMakeDel(arrctg, arr, name )
    {
        arrctg.push('<p id="img"><img id="list"  src="./img/' + 
        arr + '" width="200" height="200"></a></p> ');
    };
    
    function btnPos(arrctg, arr, name )
    {
        arrctg.push('<p><button type="button" id="' + 
        name + '" class="add">追加</button></p> ');
    };

});
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<[$()ここまで]>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
