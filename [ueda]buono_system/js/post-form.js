$(function(){
	$("#post_form").hide();
  $('#post_button button').click(function(){
  	console.log($(this));
  	if( $(this).hasClass("on") ){
  		//post
  		$("#open").attr("src","img/close.png");
  		$(this).removeClass("on");
  		$("#post_form").show();
  	} else {
  		//close
  		$("#open").attr("src","img/post_icon.png");
  		$(this).addClass("on");
  		$("#post_form").hide();
  	}
 });
});