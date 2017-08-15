<?php 
	include_once "fun.php";
	if(judgeLogin()){
		msg(1, "已登录", "usericon.php");
	}else{
	$type2 = isset($_GET["type2"]) && intval($_GET["type2"]) ? intval($_GET["type2"]) : 1;
	/*当页面地址栏中输入$type值时，判断是否为可选值*/
	// var_dump($type2);die;
	if(!in_array($type2, array(2, 1))){
		msg(0, "请登录", "reg.php");
	}
	

	/*注册部分*/
	if(!empty($_POST["username"])){
		$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");//连接数据库
		$username = mysql_real_escape_string(trim($_POST["username"]));
		$password = mysql_real_escape_string(trim($_POST["password"]));
		$result = $pdo->query("select count(id) as total from user where username = '{$username}'");
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		// print_r($row);
		if($row[0]["total"] > 0){
			reg(0, "用户名已存在", 2);//2-->转向注册页面
		}else{
			$time = time();
			$usericon = "http://localhost/PHP/PianKe/img/default_icon.jpg";
			$password = md5(md5($password)."pk");
			$result = $pdo->exec("insert into user(username, password, createTime, usericon) values('{$username}', '{$password}', {$time}, '{$usericon}')");
			if($result){
				reg(1, "注册成功", 1);//1-->转向登录页面
				// msg(1, "注册成功", "usericon.php");
			}else{
				reg(0, "用户名已存在", 2);//2-->转向注册页面
			}
		}
	}

	/*登录部分*/
	if(!empty($_POST["user"])){
		$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");//连接数据库
		$username = mysql_real_escape_string(trim($_POST["user"]));
		$password = mysql_real_escape_string(trim($_POST["psd"]));
		$result = $pdo->query("select * from user where username = '{$username}' limit 1");
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		// print_r($row);die;
		
		if(count($row) > 0){
			$password = md5(md5($password)."pk");
			if($row[0]["password"] === $password){
				session_start();
				$_SESSION["pkUser"] = $row[0];
				// print_r($_SESSION);die;
				msg(1, "登录成功", "index.php");
			}else{
				reg(0, "密码错误", 0);
			}
		}else{
			reg(0, "用户名不存在", 0);
		}
	}
}

	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>片刻</title>
		<link rel="stylesheet" type="text/css" href="css/swiper-3.4.2.min.css" />
		<link rel="stylesheet" href="css/reg.css">
	</head>
	<body>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><img src="img/bg1.jpg" alt=""></div>
				<div class="swiper-slide"><img src="img/bg3.jpg" alt=""></div>
				<div class="swiper-slide"><img src="img/bg4.jpg" alt=""></div>
				<div class="swiper-slide"><img src="img/bg5.jpg" alt=""></div>
			</div>
		</div>
		<div class="words">
			<h1>世界很美，<br />而你正好有空。</h1>
			<h3>Stay with me，look around the world</h3>
		</div>
		<div class="reg">
			<div class="logo">
				<img class="logo_img" src="img/logo1.png" alt="">
				<p>世界很美，而你正有空</p>
			</div>
			<div class="outer">
				<ul class="nav">
					<li class="active">登录</li>
					<li>注册</li>
				</ul>
				<div class="content show">
					<form action="reg.php" id="login_form" method="post">
						<input type="text" id="user_l" name="user" placeholder="请输入用户名"><br />
						<input type="password" id="password_l" name="psd" placeholder="密码">
						<a href="" id="wjmm">忘记密码?</a>
						<input type="submit" id="login_btn" value="登录">
				</form>
				</div>
				<div class="content">
					<form action="reg.php" id="reg_form" method="post">
						<input type="text"  id="user" name="username" placeholder="创建用户名"><br />
						<input type="password" id="password" name="password" placeholder="输入密码">
						<input type="password" id="password1" placeholder="确认密码">
						<input type="submit" id="reg_btn" value="注册">
					</form>
				</div>
			</div>
		</div>
		<script src="js/jquery-1.8.3.min.js"></script>
		<script src="js/swiper-3.4.2.min.js"></script>
		<script src="js/layer/layer.js"></script>
		<script src="js/reg.js"></script>
		
		<!-- 根据URL中传的$type设置登录或者注册 -->
		<?php if(isset($type2)): ?>
			<script>
				$('.nav li').removeClass('active');
				$(".nav li").eq(<?php echo $type2; ?> - 1).addClass('active');
				$('.content').removeClass('show').eq(<?php echo $type2; ?> - 1).addClass('show');
			</script>
		<?php endif;?>

	</body>
	</html>