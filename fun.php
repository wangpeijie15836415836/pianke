<?php 
	//连接数据库
function mysqlInit($dbms, $host, $dbname, $username, $password){
	$dsn = "{$dbms}:host={$host};dbname={$dbname}";
	$pdo = new PDO($dsn, $username, $password);
	$pdo->query("set names utf8");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	return $pdo;
}

	//跳转页面的判断
function msg($type, $words=null, $url=null){
	$msg = "msg.php?type1={$type}";
	$msg .= $words ? "&words={$words}" : "";
	$msg .= $url ? "&url={$url}" : "";
	return header("location:{$msg}");
}

	//注册验证
function reg($type1, $words=null, $type2=null){
	$msg = "msg.php?type1={$type1}";
	$msg .= $words ? "&words={$words}" : "";
	$msg .= "&type2={$type2}";
	return header("location:{$msg}");
}

	//判断用户是否登录
function judgeLogin(){
	session_start();
	if(isset($_SESSION["pkUser"])){
		return true;
	}else{
		return false;
	}
}

	//设置特殊字符、去空格
function s_str($str){
	return mysql_real_escape_string(trim($str));
}

	//获取session中user的id
function get_user_id(){
		// session_start();
	$user_id = $_SESSION["pkUser"]["id"];
	return $user_id;
}

	//设置上传头像
function setIcon($img=null){
	if($img == null){
		$imagenurl = "img/default_icon.jpg";
	}else{
		$image = base64_decode($img);
		$imagename = uniqid().rand(100, 999).".jpg";
		$imagenurl = "usericon/{$imagename}";
		$a = file_put_contents($imagenurl, $image);
	}
		return $imagenurl;//返回用户头像存放的临时路径usericon/598d7582eb6c3131.jpg
	}

	//上传用户头像
	function userIcon($img_url, $user_id){
		if(!file_exists($_POST["img_url"])){
			return;
		}
		// print_r($user_id);die;

		$imgname = explode(".", explode("/",$img_url)[1])[0];

		$user_icon_dir_path = "file/{$user_id}/usericon/";//每个用户生成唯一文件夹用来存储个人信息.date("Y/md", time())."/"
		//判断唯一的文件夹是否存在，若不存在则创建文件夹
		if(!is_dir($user_icon_dir_path)){
			mkdir($user_icon_dir_path, 0777, true);
		}
		$user_icon_path = $user_icon_dir_path.$imgname.".jpg";//在项目目录下，用户头像的绝对路径file/33/2017/0811/598d72fce0465525.jpg
		$imgUrl = "http://localhost/D-test7/".$user_icon_path;
		
		// 将临时文件夹下用户头像拷贝到用户目录下
		if(copy($img_url,$user_icon_path)){
			unlink($img_url); //删除临时目录下的原文件
			return $imgUrl;
		}
	}

	//更新session
	function updataSession($user_id, $pdo){
		$result = $pdo->query("select * from user where id = '{$user_id}' limit 1");
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION["pkUser"] = $row[0];
	}

	//上传文件
	function upload($file, $user_id,$type=null){
		if(!is_uploaded_file($file["tmp_name"])){
			msg(0, "非法上传路径");
		}else{
			$arr = array("image/png", "image/gif", "image/jpeg");
			$arr1 = array("audio/mp3", "audio/ogg", "image/wav");

			if($type){
				if(!in_array($file["type"], $arr1)){
					msg(0, "请上传mp3、ogg或wav格式类型音频");exit;
				}
			}
			if(!in_array($file["type"], $arr) && !$type){
				msg(0, "请上传png、jpg或gif格式类型图片");exit;
				
			}
			$file_path = "file/{$user_id}/".date("Y/md", time())."/";
			if(!is_dir($file_path)){
				mkdir($file_path, 0777, true);
			}
			$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));//获取文件后缀
			$img_name = uniqid().rand(1000, 9999);
			$img_path = $file_path.$img_name.".".$ext;
			$img_url = "http://localhost/D-test7/".$img_path;
			if(move_uploaded_file($file["tmp_name"], $img_path)){
				return $img_url;
			}else{
				msg(0, "操作失败，请重试！");
			}
			
		}
	}



	//发布成功或者失败
	function s_or_l($result){
		if($result){
			msg(1, "操作成功！", "user.php");
		}else{
			msg(0, "发布失败！");
		}
	}

	//获取用户头像
	function get_user($pdo,$user_type, $user_id){

		$result = $pdo->query("select {$user_type} from user where id = {$user_id} limit 1");
		// echo $user_type.$user_id;
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row["{$user_type}"];
	}

	function qita($pdo, $w_id, $zan_or_view){
		$result = $pdo->query("select {$zan_or_view} from works where works_id = {$w_id}");
		$row = $result->fetch(PDO::FETCH_ASSOC);
		// print_r($row);die;	
		$z_v = $row["$zan_or_view"] + 1;
		$result = $pdo->query("update works set {$zan_or_view} = {$z_v} where works_id = {$w_id}");
	}

	function comment_count($pdo, $w_id){
		$result = $pdo->query("select count(id) as total from comment where works_id = {$w_id}");
		$row = $result->fetch(PDO::FETCH_ASSOC);
		// print_r($row["total"]);die;
		return $row["total"];
	}

?>