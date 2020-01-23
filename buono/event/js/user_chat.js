(function(){
//--チャット表示
document.addEventListener('DOMContentLoaded',e=>{

	if(window.localStorage){
		//--遷移型であるので、phpから遷移してきたことを想定していったん保持している保存情報をクリアしておく
		localStorage.clear();

		if(!localStorage.getItem("lastEventId")){
			localStorage.setItem("startFlag","1");
			localStorage.setItem("lastEventId","-1");
		}
	}

	const es = new EventSource("../php/api_chat.php");
	//console.log("init -> " + es.readyState);

	es.addEventListener("error",function(e){
		if( es.readyState === EventSource.CONNECTING ){// === 0
			//console.log("接続中 or 再接続中");
		} else if( es.readyState === EventSource.OPEN ){// === 1
			//console.log("接続済み");
		} else if( es.readyState === EventSource.CLOSED ){// === 2
			// 終了
			es.close(); // エラーが起きても再接続する必要がない場合はclose()を実行する
		}
	},false);

	//オリジナルevent.typeはaddEventListenerでないと拾えない
	//es.oncontrolend = function(e){
	//	console.log("Connection close controlend");
	//	es.close();
	//}
	es.addEventListener("controlend",function(e){
		console.log("Connection close controlend");
		console.log("readyState:",es.readyState);
		es.close();
	},false);

	es.addEventListener("ping",function(e){
		const {cid,ctext,cmade,created_at} = JSON.parse(e.data);

		//--オーナー処理
		let cssown = "";
		let owner = atob(document.body.getAttribute("data-owner"));
		let sample = document.querySelector("#sample");
		//console.log("オーナー：",owner);
		if( owner == cmade ){
			let cl = sample.getAttribute("class");
			if( !/own/.test(cl) ){
				if( cl ){
					sample.setAttribute("class",cl+" own");
				} else {
					sample.setAttribute("class","own");
				}//-- if hasClass
			}//--if test
		}//--if class

		if( localStorage.getItem("lastEventId") == "-1" || parseInt(e.lastEventId) > parseInt(localStorage.getItem("lastEventId")) ){
			localStorage.setItem("lastEventId",e.lastEventId);
			let sample = document.querySelector("#sample");
			let li = document.createElement("li");
			if( owner == cmade ){//--発言者オーナーなら赤色にするためクラス付与
				li.className = "info";
			}
			li.innerHTML = `${created_at}<br />${ctext}<br />発言者：${cmade}<br />ID：${cid}`;
			sample.appendChild(li);
		}

	},false);

	document.querySelector("#reset").addEventListener("click",function(e){
		localStorage.clear();
	},false);

});

})();



/*
後学のために※1,2,3はほぼ同じ挙動をする

documentがロードされたタイミングで実行＝<body>がロードされてから匿名関数として実行


※1
(function(){
//<body>内に記述するので、<body>がロードされてから匿名関数として実行する
})();


※2
document.addEventListener('DOMContentLoaded',function(e){
//documentがロードされたタイミングで実行する
});

※3
document.addEventListener('DOMContentLoaded',e=>{
//documentがロードされたタイミングで実行する
});


*/
