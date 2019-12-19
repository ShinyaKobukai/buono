$(function(){
	$("#post_form").hide();
	$("#black-layer").hide();
  $('#post_button button').click(function(){
  	//クリックしたときの状態でifが分かれる
  	if( $(this).hasClass("on") ){
  		//post
  		$("#open").attr("src","img/close.png");
  		$(this).removeClass("on");
  		$("#post_form").show();
  		$("#black-layer").show();
  	} else {
  		//close
  		$("#open").attr("src","img/post_icon.png");
  		$(this).addClass("on");
  		$("#post_form").hide();
  		$("#black-layer").hide();
  	}
 });
});