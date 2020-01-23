(function(){

	window.onsubmit = function(){
		let [uid,pwd,btn] = [
			document.querySelector("#uid"),
			document.querySelector("#pwd"),
			document.querySelector('button[type="submit"]'),
		];
		console.log(Date.now());
		btn.value = btoa(Date.now());//日時をミリ秒化かつ日本語ではないのでエンコード不要
		console.log(btn.value);
		if( uid.value != "" && pwd.value != "" ){
			return confirm("本当にユーザー登録しますか");
		} else {
			alert("ユーザー名またはパスワードが不正です");
			return false;
		}
		return false;
	}

})();