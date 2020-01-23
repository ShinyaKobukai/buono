(function(){
//--書き込み
	window.onsubmit = function(){
		let [uipt,btn] = [
			document.querySelector("#uinput"),
			document.querySelector('button[type="submit"]'),
		];
		btn.value = btoa(Date.now());//日時をミリ秒化かつ日本語ではないのでエンコード不要
		console.log(btn.value);
		if( uipt.value != "" ){
			return confirm("発言しますか");
		} else {
			alert("発言記述がありません");
			return false;
		}
		return false;
	}
	document.querySelector("#reset").addEventListener("click",e=>{
		if(confirm("テーブル履歴を破棄しますか")){
			localStorage.clear();
		}
	},false);
})();