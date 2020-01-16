(function(){
//--チャット表示
document.addEventListener('DOMContentLoaded',e=>{
//--ここより↓

	if(window.localStorage){
		localStorage.clear();
		if(!localStorage.getItem("lastEventId")){
			localStorage.setItem("startFlag","1");
			localStorage.setItem("lastEventId","-1");
		}
	}//--end if

	const es = new EventSource("/test/event/php/api_chat.php");
	console.log("init -> " + es.readyState);

	//オリジナルevent.typeはaddEventListenerでないと拾えない
	es.addEventListener("controlend",e=>{
		console.log("Connection close controlend");
		console.log("readyState:",es.readyState);
		es.close();
	},false);

	es.addEventListener("ping",e=>{
		const {cid,ctext,cmade,created_at} = JSON.parse(e.data);

		if( localStorage.getItem("lastEventId") == "-1" 
			|| parseInt(e.lastEventId) > parseInt(localStorage.getItem("lastEventId")) ){
			localStorage.setItem("lastEventId",e.lastEventId);

			//--オーナー処理
			let cssown = "";
			let owner = atob(document.body.getAttribute("data-owner"));
			console.log("オーナー：",owner);
			if( owner == cmade ){
				cssown = " own";
			}








			let sample = document.querySelector("#sample");
			let li = document.createElement("li");
			li.innerHTML = 
`
	<div class="chat${cssown}">
		<div class="info">
			<span class="postid"><i class="fas fa-key"></i>&nbsp;${cid}</span>
			<span class="made"><i class="far fa-comment"></i>&nbsp;${cmade}</span>
			<span class="time" data-time="${created_at}"><i class="far fa-calendar-alt"></i>&nbsp;${setXtime(created_at)}</span>
		</div><!-- /.info -->
		<div class="message">
			${ctext}
		</div><!-- /.message -->
	</div><!-- /.chat -->
`;
			sample.appendChild(li);
		} else {

		}//--end if

	},false);









	document.querySelector("#reset").addEventListener("click",e=>{
		if(confirm("テーブル履歴を破棄しますか")){
			localStorage.clear();
		}
	},false);

	document.querySelector("#submit").addEventListener("click",e=>{
		let cmade = document.querySelector("#cmade").value;
		let uinput = document.querySelector("#uinput").value;
		if( cmade != "" && uinput != "" ){
			if(confirm("発言しますか")){
				POST_chat(cmade,uinput);
			}//--end if
		} else {
			alert("発言者または発言内容がありません");
		}//--end if
	},false);

	async function POST_chat(from,chat){
		let xDATA  = { cmade : from, uinput : chat }
		xDATA = JSON.stringify(xDATA);
		const res = await fetch("/event/php/api_post.php",{
			method  : "POST",
			headers : {"content-type":"application/json","accept":"application/json"},
			body    : xDATA
		});
		const data = await res.json();
		console.log(data);

		if( data.status == "success" ){
			//発言成功
		} else {
			alert("発言失敗");
		}//--end if
	}//--end async function

	function setXtime(str_time){
		let str = str_time.split(" ");
		let xdate = str[0].split("-");
		let xclock = str[1].split(":");
		let [xdate_obj,xclock_obj] = ["",""];
		let d = new Date();
		let yy = d.getFullYear();
		let mm = d.getMonth()+1;
		let dd = d.getDate();
		let hh = d.getHours();
		let ii = d.getMinutes();
		let ss = d.getSeconds();
		mm = mm <= 9 ? "0"+mm : mm;
		dd = dd <= 9 ? "0"+dd : dd;
		hh = hh <= 9 ? "0"+hh : hh;
		ii = ii <= 9 ? "0"+ii : ii;
		ss = ss <= 9 ? "0"+ss : ss;
		//日付処理
		if( xdate[0] == yy ){
			if( xdate[1] == mm && xdate[2] == dd ){
				xdate_obj = "";
			} else {
				xdate_obj = mm+"/"+dd;
			}
		} else {
			xdate_obj = str[0];
		}
		//時刻処理
		if( xdate_obj == "" ){
			//当日
			xclock_obj = xclock[0]+":"+xclock[1];
		} else {
			//別日
			xclock_obj = "";
		}
		return (xdate_obj+""+xclock_obj);
	}//--end function

//--ここより↑
});
})();
