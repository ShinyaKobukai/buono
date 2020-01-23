(function(){

	window.onsubmit = function(){
		let [uid,pwd,btn] = [
			document.querySelector("#uid"),
			document.querySelector("#pwd"),
			document.querySelector('button[type="submit"]'),
		];
		if( uid.value != "" && pwd.value != "" ){
			return confirm("本当にログインしますか");
		} else {
			alert("ユーザー名またはパスワードが不正です");
			return false;
		}
		return false;
	}

})();