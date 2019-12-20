$(function(){
	var count = $(".introduce li").length;
	var current = 1;
	var next = 2;
	var interval = 5000;
	var duration = 500;
	var timer;

	// 1番目の写真以外は非表示
	$(".introduce li:not(:first-child)").hide();

	// 3000ミリ秒（変数intervalの値）ごとにslideTimer関数を実行
	timer = setInterval(slideTimer, interval);

	// slideTimer関数
	function slideTimer(){
		$(".introduce li:nth-child(+" + current + ")").fadeOut(duration);
		$(".introduce li:nth-child(+" + next + ")").fadeIn(duration);


		current = next;
		next = ++next;

		if(next > count){
			next = 1;
		}

		$("#button li a").removeClass("target");
		$("#button li:nth-child("+ current +") a").addClass("target");
	}

	$("#button li a").click(function(){
		next = $(this).html();

		clearInterval(timer);
		timer = setInterval(slideTimer, interval);

		slideTimer();

		return false;
	});
});
