(function(){
//--ここより↓

	let msg = document.querySelector("#msg");
	let btn_commit = document.querySelector("#submit");

	function check(num,e){
		let msg = "";
		switch(num){
			case 1:
				msg = "ユーザーIDの入力がありません";
				break;
			default:
				msg = "入力がありません";
		}
		if( e.value == "" ){
			e.nextElementSibling.innerHTML = msg;
			return false;
		} else {
			e.nextElementSibling.innerHTML = "";
			return true;
		}
	}//--end function


	//--ユーザーIDの入力チェック
	msg.onblur = function(){
		check(1,this);
	}

	


	//--ユーザーID＆パスワードの入力があった場合、ログインするかどうか確認
	window.onsubmit = function(){
		if( check(1,msg) && confirm("入力内容に間違いはありませんか？") ){
			return true;
		}
		return false;
	}//--onclick
	
	
//--ここより↑
})();