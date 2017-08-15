<?php 
	include_once "fun.php";
	if(!judgeLogin()){
		msg(0, "请登录!", "reg.php");
	}else{
		$user_id = get_user_id();
		$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");
		$result = $pdo->query("select * from works where user_id = {$user_id}");
		$works = $result->fetchAll(PDO::FETCH_ASSOC);
//		 print_r($works);die;
	}
	

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="css/user.css"/>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="stylesheet" href="css/usericon.css">
<script src="js/jquery.min-1.9.1.js"></script>
<script src="js/jquery.easing.min.js"></script>	

</head>
<body>
	<!--设置导航栏-->
	<div id="topSearch">
		<header style="position: fixed;">
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
				<div class="massage">
					<div class="msg-icon">
						<img src="img/msg.png" width="44px">
					</div>
				</div>
				<div class="userinfo1" style="height:100%;">
					<a href="#">
						<img src="<?php echo $_SESSION["pkUser"]["usericon"];?>" class="user-icon">
					</a>
					<div class="msg-menu" style="top: 90px;">
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
			</div>
		</div>
	</header>

		
	</div>
	
			
		<script type="text/javascript">
			
			var topSearch = document.getElementById('topSearch');
//			var goTop = 0;
//			var time = null;
//			var time1 = null;
//			
			$(function(){
				$(window).scroll( function(){
				
//				当浏览器发生滚动时,不断获取当前滚动条距离浏览器顶部的距离
				var goTop = document.documentElement.scrollTop||document.body.scrollTop;
							
				if(goTop >= 100){	
		                  $("#topSearch").fadeOut(500);

				}
				else{
					
					 $("#topSearch").fadeIn(500); 

				}
			})
			})
			
		</script>
	
		
		
	<!--设置主题内容-->
	<div class="wpj">
		<div class="user-icon-group">
			<div class="user-icon">
				<img src="<?php echo $_SESSION["pkUser"]["usericon"];?>"/>
			</div>
			<div class="user-info">
				<div class="user-name">
					<span><?php echo $_SESSION["pkUser"]["username"];?></span>
					<span class="btn-focus"></span>
				</div>
				<div class="user-des">
					<?php echo $_SESSION["pkUser"]["userwords"];?>
				</div>
				<div class="user-others">
					<a href="">
						"25480"
						<br />
						<span>粉丝</span>
					</a>
					<a href="">
						"176"
						<br />
						<span>关注</span>
					</a>
					<a href="">
						"30647"
						<br />
						<span>访客</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!--设置瀑布流-->

		<div class="data-title data-title-home">
			<span class="">
				<a href="">全部</a>
				（157）
			</span>
			<span>
				<a href="">文章</a>
				（137）
			</span>
			<span>
				<a href="">听</a>
				（20）
			</span>
		</div>
	
	<section id="gallery-wrapper">
		<?php foreach($works as $v): ?>
		<article class="white-panel">
			<img style="height: 270px;" src="<?php echo $v["img_pic"];?>" class="thumb" >
			<h1><a href="detail.php?w_id=<?php echo $v["works_id"]."&w_type=".$v["works_type"];?>"><?php echo $v["title"];?></a></h1>
	  		<p><?php echo $v["content"];?></p>
		</article>
		<?php endforeach; ?>

					
   </section>	
	
	<!-- <script src="http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js" type="text/javascript"></script> -->
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="js/pinterest_grid.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#gallery-wrapper").pinterest_grid({
				no_columns: 4,
                padding_x: 10,
                padding_y: 10,
                margin_bottom: 50,
                single_column_breakpoint: 700
			});
		});
	</script>
	
</body>
</html>