<?php 
	// session_start();
	// print_r($_SESSION);die;
	$type1 = isset($_GET["type1"]) && intval($_GET["type1"]) ? intval($_GET["type1"]) : 0;
	$words = isset($_GET["words"]) && !empty($_GET["words"]) ? $_GET["words"] : "操作失败";
	$url = isset($_GET["url"]) && !empty($_GET["url"]) ? $_GET["url"] : null;
	// print_r($url);die;
	$type2 = isset($_GET["type2"]) && intval($_GET["type2"]) ? intval($_GET["type2"]) : null;
	if($type2 == 2){
		$url = "reg.php?type2=2";//$type2=1-->转向注册
	}
	if($type2 == 1){
		$url = "reg.php?type2=1";//$type2=0-->转向登录
	}
	// var_dump($type2);die;
	// print_r($type1);die;
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $words; ?></title>
	<link rel="stylesheet" type="text/css" href="css/done.css" />
	<link rel="stylesheet" href="css/msg.css">
</head>
<body>
	<div class="logo">
		<img src="img/logo150.png" alt="">
		<p>世界很美，而你正有空</p>
	</div>
	<div class="content">
		<div class="center">
			<div class="image_center">
			<?php if($type1 === 1): ?>
				<span class="smile_face">:)</span> 
			<?php elseif($type1 === 0): ?>
				<span class="smile_face">:( </span>  
			<?php endif; ?>
			</div>
			<div class="code"><?php echo $words; ?></div>
			<div class="jump">
				页面在<strong id="time" style="...">1</strong>秒后跳转
			</div>
		</div>

	</div>
</body>
<script src="js/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
		var time = 1;
		var url = "<?php echo $url; ?>"||null;//js读取php变量
		setInterval(function(){
			if(time > 1){
				time--;
				$("#time").html(time);
			}else{
				$("#time").html("0");
				if(url){
					location.href = url;
				}else{
					history.go(-1);
				}
			}
		},1000)
	})
</script>
</html>
