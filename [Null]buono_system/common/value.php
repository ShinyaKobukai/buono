<?php 
	function parameter(){
		$P['user_name'] = trim(htmlspecialchars($_POST['user_name']));
		$P['password'] = trim(htmlspecialchars($_POST['password']));
		$P['user_id'] = trim(htmlspecialchars($_POST['user_id']));
		$P['content'] = trim(htmlspecialchars($_POST['content']));
		$P['food_name'] = trim(htmlspecialchars($_POST['food_name']));
		$P['place'] = trim(htmlspecialchars($_POST['place']));
		return $P;
	}

	function photo(){
		$data = file_get_contents($_FILES["photo"]["tmp_name"]);
		$data = str_replace("data:image/jpeg;base64,","",$data);
		$data = base64_encode($data);
		return $data;
	}
?>