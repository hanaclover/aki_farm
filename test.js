$(function(){
	$('#loop').each(function(){
		var loopsliderWidth = $(this).width();
		var loopsliderHeight = $(this).height();
		$(this).children('ul').wrapAll('<div id="loop_wrap"></div>');
		
		var listWidth = $('#loop_wrap').children('ul').children('li').width();
		var listCount = $('#loop_wrap').children('ul').children('li').length;
		
		var loopWidth = (listWidth)*(listCount);
		$('#loop_wrap').css({
			top: '0',
			left: '0',
			width: ((loopWidth) * 2),
			height: (loopsliderHeight),
			overflow: 'hidden',
			position: 'absolute'
		});
		
		$('#loop_wrap ul').css({
			width: (loopWidth)
		});
		
		loopsliderPosition();
		
		function loopsliderPosition(){
			$('#loop_wrap').css({left:'0'});
			$('#loop_wrap').stop().animate({left:'-' + (loopWidth) + 'px'},25000,'linear');
			setTimeout(function(){
				loopsliderPosition();
			},25000);
		};
		
		$('#loop_wrap ul').clone().appendTo('#loop_wrap');
	});

	$('.NGbutton').click(function(){
		$('.NGbutton').toggleClass('OKbutton');
	});

	$('#checkbox').on('change',function(){
	 
		console.log($('#checkbox:checked').val());
		console.log($('#checkbox').prop('checked'));
	});
});

