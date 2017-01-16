function showTips(content, time) {
	if(arguments.length < 1) {
		alert("缺少参数");
		return false;
	}

	var time;

	if(arguments.length < 2) {
		time = time || 2000;
	}

	$(".tips_layer_wrap").find('.tips_layer').text(content);
	$(".tips_layer_wrap").show();

	setTimeout(function() {
		$(".tips_layer_wrap").fadeOut();
	}, time);
}

// function preventDefault(e) {
//     e = e || window.event;
//     e.preventDefault && e.preventDefault();
//     e.returnValue = false;
// }

// function stopPropagation(e) {
//     e = e || window.event;
//     e.stopPropagation && e.stopPropagation();
//     e.cancelBubble = false;
// }

// var disableScroll = function() {
//     $(document).on('mousewheel', preventDefault);
//     $(document).on('touchmove', preventDefault);
// };

// var enableScroll = function() {
//     $(document).off('mousewheel', preventDefault);
//     $(document).off('touchmove', preventDefault);
// };

// disableScroll();