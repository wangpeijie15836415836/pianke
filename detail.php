<?php 
	include_once "fun.php";
	$judgeLogin = judgeLogin();//判断是否为登录状态
	$w_id = isset($_GET["w_id"]) && intval($_GET["w_id"]) ? intval($_GET["w_id"]) : null;
	$w_type = isset($_GET["w_type"]) && intval($_GET["w_type"]) ? intval($_GET["w_type"]) : null;
	// var_dump($w_id);
	$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");
	$result = $pdo->query("select * from works where works_id = {$w_id}");
	$result_type = $pdo->query("select * from works where works_type = {$w_type}");

	if($result && $result_type){
		qita($pdo, $w_id, "view");
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		// print_r($row);die;
		$result = $pdo->query("select * from comment where works_id = {$w_id}");
		$comment = $result->fetchAll(PDO::FETCH_ASSOC);
		 // print_r($comment);die;
		$result = $pdo->query("select count(works_id) as total from comment where works_id = {$w_id}");
		$comment_count = $result->fetchAll(PDO::FETCH_ASSOC);
		// print_r($comment_count);die;
		$c_count = $comment_count[0]["total"];



	}else{
		msg(0, "访问的作品不存在");
	}


	if($judgeLogin){
		$user_id = $_SESSION["pkUser"]["id"];
		$result = $pdo->query("select zan from qita where user_id = {$user_id} and works_id = {$w_id}");
		$y_or_n_zan = $result->fetch(PDO::FETCH_ASSOC);
		// var_dump($y_or_n_zan["zan"]);die;
		if(!empty($_POST["cont"])){
			$cont = s_str($_POST["cont"]);
			$comment_time = time();
			// print_r($zan);die;
			$result = $pdo->exec("insert into comment(works_id, user_id, cont, comment_time) values({$w_id}, {$user_id}, '{$cont}', {$comment_time})");
			if($result){
				msg(1, "评论成功");
			}else{
				msg(0, "评论失败");
			}
		}
	}


	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $row[0]["title"];?></title>
		<link rel="stylesheet" href="css/usericon.css">
		<link rel="stylesheet" href="css/detail.css" />
		<link rel="stylesheet" href="css/base.css" />
	</head>
	<body>
	<div id="topSearch">
			<header style="position: fixed; top: 0;">
				<div class="head">
					<div class="head-logo"><a href=""></a></div>
					<ul class="navbar1">
						<li class=""><a href="#">首页</a></li>
						<li class=""><a href="#">阅读</a></li>
						<li class=""><a href="#">电台</a></li>
						<li class=""><a href="#">碎片</a></li>
						<li class=""><a href="index.php">动态</a></li>
						<li class=""><a href="#">客户端</a></li>
					</ul>
					<div class="navbar-icon">
						<div class="editer">
							<a href="publish.php" style="display: block;; height: 100%;">
								<div>
									<img src="img/edit-icon.png" width="19px" height="20px">
								</div>
							</a>
						</div>
						<?php if($judgeLogin): ?>
							<div class="massage">
								<div class="msg-icon">
									<img src="img/msg.png" width="44px">
								</div>
							</div>
							<div class="userinfo1">
								<a href="user.php">
									<img src="<?php echo $_SESSION["pkUser"]["usericon"];?>" class="user-icon">
								</a>
								<div class="msg-menu">
									<div class="drop-menu userinfo-drop">
										<ul>
											<li>
												<a href="usericon.php">账号设置</a>
											</li> 
											<li>
												<a href="exit.php">退出</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<?php elseif(!$judgeLogin): ?>
							<div class="login-btn"><a href="reg.php">登录&nbsp;<span>/</span>&nbsp;注册</a></div>
						<?php endif; ?>
					</div>
				</div>
		</header>
		</div>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript">
			var topSearch = document.getElementById('topSearch');		
			$(function(){
				$(window).scroll(function(){
					//当浏览器发生滚动时,不断获取当前滚动条距离浏览器顶部的距离
					var goTop = document.documentElement.scrollTop||document.body.scrollTop;
					if(goTop >= 100){	
						$("#topSearch").fadeOut(500);
					}
					else{
						$("#topSearch").fadeIn(500); 
					}
				});
			});
		</script>
		
		<!-- 文章 -->
		<?php if($w_type == 1): ?>
		<div class="box">
			<div class="article">
				<h2><?php echo $row[0]["title"];?></h2>
				<p>
					<span><img src="<?php echo get_user($pdo, "usericon", $row[0]["user_id"]);?>" alt="" /><?php echo get_user($pdo, "username", $row[0]["user_id"]);?></span>
					<span>
						<item><?php echo date("Y-m-d H:i", $row[0]["public_time"]);?></item>&nbsp&nbsp
						<item>阅读时间：3分钟</item>&nbsp&nbsp
						<item style="border-right:none;">阅读次数:<?php echo $row[0]["view"]; ?></item>
					</span>
				</p>
			</div>
			<div class="text">
				<img src="<?php echo $row[0]["img_pic"];?>" width="640">
				<p><?php echo $row[0]["content"]; ?></p>
			</div>
			<div class="like clearfix">
				<div class="data fl">
					<img src="img/like.png" alt="" />
					<span><?php echo $row[0]["zan"];?></span>
				</div>
				<div class="contect fr">
					<a href=""><img src="img/l7.png" alt="" /></a>
					<a href=""><img src="img/l8.png" alt="" /></a>
					<a href=""><img src="img/l9.png" alt="" /></a>
					<a href=""><img src="img/l10.png" alt="" /></a>
				</div>
				<div class="comment">
					<form action="detail.php?w_id=<?php echo $_GET["w_id"]."&".$_GET["w_type"];?>" method="post">
						<textarea name="cont" id="" max-width="360" placeholder="发表你的精彩评论啦"></textarea>
						<i></i>
						<input type="submit" id="" value="发表评论" />
					</form>
				</div>
			</div>
			<ul class="record">
				<p>评论(<?php echo $c_count; ?>  条)</p>
				<?php foreach($comment as $v): ?>
				<li>
					<div class="icon">
						<img src="<?php echo get_user($pdo, "usericon", $v["user_id"]);?>" alt="" />
					</div>
					<div class="text_d">
						<p><?php echo get_user($pdo, "username", $v["user_id"]);?><span><?php echo date("Y-m-d H:i:s", $v["comment_time"]); ?></span></p>
						<p><?php echo $v["cont"];?></p>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

		<!-- Ting -->
		<?php elseif($w_type == 2): ?>

			<div class="box1">
			<div class="pic clearfix">
				<div class="pic_l fl">
					<img src="<?php echo $row[0]["img_pic"]; ?>" alt="" />
				</div>
				<div class="pic_r fl">
					<h2><?php echo $row[0]["title"];?></h2>
					<p><span><?php echo $row[0]["view"]; ?></span>次播放&nbsp&nbsp|&nbsp&nbsp评论：<span><?php echo $c_count; ?></span>&nbsp&nbsp|&nbsp&nbsp喜欢：<?php echo $row[0]["zan"];?></p>
					<p>主播：<span><?php echo get_user($pdo, "username", $row[0]["user_id"]);?></span></p>
					<p>原文：<span><?php echo get_user($pdo, "username", $row[0]["user_id"]);?></span></p>
					<div class="pic_t">
						<div class="music">
							<span><i>播放</i>Ting</span>		
							<img src="img/pause.png" id="pause"/>
							<img src="img/play.png" alt="" id="play"/>
							<video style="width: 120px; height: 50px;position: relative; z-index: 100;" src="<?php echo $row[0]["music_pic"];?>" autoplay="autoplay" loop="loop"></video>
						</div>
						<div class="like ilike"></div>
					</div>
				</div>
			</div>
			<p id="test"><span></span>&nbsp&nbsp原文</p>
			<div class="detail">
				<p><?php echo $row[0]["content"]; ?></p>
			</div>
			<div class="p2">
				<div class="comment">
					<form action="detail.php?w_id=<?php echo $_GET["w_id"]."&".$_GET["w_type"];?>" method="post">
						<textarea name="cont" id="" max-width="360" placeholder="发表你的精彩评论啦"></textarea>
						<i></i>
						<input type="submit" id="" value="发表评论" />
					</form>
				</div>
				<ul class="record">
				<p>评论(<?php echo $c_count; ?>  条)</p>
				<?php foreach($comment as $v): ?>
				<li>
					<div class="icon">
						<img src="<?php echo get_user($pdo, "usericon", $v["user_id"]);?>" alt="" />
					</div>
					<div class="text_d">
						<p><?php echo get_user($pdo, "username", $v["user_id"]);?><span><?php echo date("Y-m-d H:i:s", $v["comment_time"]); ?></span></p>
						<p><?php echo $v["cont"];?></p>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
			</div>
			</div>
			
	<?php endif; ?>
	
	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/jquery.easing.min.js"></script>
		<script>
			$("#pause").css("display","block");
			$("#play").css("display","none");
			$(".music span i").html("暂停");
			var flag = true;
			$('video').on('click', function(){
				if(flag){
					$('video').get(0).pause();
					flag = !flag;
					$("#pause").css("display","none");
					$("#play").css("display","block");
					$(".music span i").html("播放");
				}else{
					$('video').get(0).play();
					flag = !flag;
					$("#pause").css("display","block");
					$("#play").css("display","none");
					$(".music span i").html("暂停");
				}
			});
			<?php if($judgeLogin): ?>
			<?php if($y_or_n_zan["zan"] == NULL): ?>
			var flag1 = true;
			$('.pic_r>.pic_t>.like, .data img').click(function(){
				if(flag1){
					flag1 = !flag1;
					$(this).css({
						background:"url(img/likeH.png) no-repeat",
						backgroundSize:"100%"
					});
					$.ajax({
						url: "qita.php",
						data: {
							"w_id":<?php echo $w_id;?>,
							"user_id":<?php echo $user_id;?>
						},
						type: "POST",
						success: function(data){
							console.log(data);
						}
					});
				}
			});
			<?php elseif($y_or_n_zan["zan"] == 1): ?>
			$('.pic_r>.pic_t>.like, .data img').css({
				background:"url(img/likeH.png) no-repeat",
				backgroundSize:"100%"
			});
			<?php endif; ?>
			<?php elseif(!$judgeLogin): ?>
			$('.pic_r>.pic_t>.like, .data img').click(function(){
				$("<div id='addTs' style='padding:10px 20px; font-size:16px; border-radius: 5px; background:rgba(0,0,0,.8);color:#fff;position:fixed;top:-50px;;left:47%;z-index:100000;'>请先登录！</div>").appendTo("body");
				$("#addTs").animate({
					top:"45%"
				},1000,"easeOutBounce");
				setTimeout(function(){
					$("#addTs").fadeOut(500);
					setTimeout(function(){
						$("#addTs").remove();
					},500);
				},3000);
			});
			<?php endif; ?>


			
		</script>
	
	</body>
</html>
