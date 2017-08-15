<?php
	include_once "fun.php";
	$judgeLogin = judgeLogin();//判断是否为登录状态
	$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");
	$result = $pdo->query("select * from works order by public_time desc");
	$all_works = $result->fetchAll(PDO::FETCH_ASSOC);
	// print_r($all_works);die;
	// $times = time() - $all_works[0]["public_time"];
	// print_r($times);die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>最新动态|片刻网</title>
	<link rel="stylesheet" href="css/usericon.css">
	<link rel="stylesheet" href="css/pianke.css">
	<link rel="stylesheet" href="css/base.css">
</head>
<body>
	<div class="container">
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
				$(window).scroll( function(){

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
		
		<div class="containers">
			<div class="title-cpt">最新动态&nbsp;&nbsp;|&nbsp;&nbsp;Lastest News</div>
			<div class="feed-container">

			<?php foreach($all_works as $v): ?>
				<?php if($v["works_type"] == 1): ?>
				<div class="feed-item">
					<div class="feed-user-info">
						<a href=""><img src="<?php echo get_user($pdo, "usericon", $v["user_id"]);?>" alt=""></a>
						<span class="user-name">
							<a href=""><?php echo get_user($pdo, "username", $v["user_id"]);?></a>
						</span>
						发布了一个文章
						<span class="time">
							<?php if((time() - $v["public_time"]) < 3600): ?>
								<?php echo floor((time() - $v["public_time"]) / 60);?> minutes ago
							<?php elseif((time() - $v["public_time"]) < 24*3600): ?>
								<?php echo floor((time() - $v["public_time"]) / (60*60));?> houre ago
							<?php elseif((time() - $v["public_time"]) < 30*24*3600): ?>
								<?php echo floor((time() - $v["public_time"]) / (60*60*24));?> day ago
							<?php endif; ?>
						</span>
					</div>
					<div class="feed-title">
						<a href="detail.php?w_id=<?php echo $v["works_id"]."&w_type=".$v["works_type"];?>"><?php echo $v["title"];?></a>
					</div>
					<div class="feed-contend feed-timeline">
						<div class="feed-user-name" style="display: none;">
							<a href="" target="_blank">By/</a>
						</div>
						<div class="timeline-content">
							<a href="" target="_blank"><?php echo $v["content"];?></a>
						</div>
						<div class="voice" style="display: none;"><a href="" target="_blank">[语音]</a></div>
						<div class="timeline-img">
							<a href=""><img src="<?php echo $v["img_pic"];?>" alt=""></a>
						</div>
						<div class="feed-others">
							
							<?php echo $v["view"];?>次阅读&nbsp;&nbsp;|&nbsp;&nbsp;评论:<?php echo comment_count($pdo, $v["works_id"]);?>&nbsp;&nbsp;|&nbsp;&nbsp;喜欢:<?php echo $v["view"];?>
							<div class="feed-del" style="display: none;">	<div class="del-btn">删除</div>
						</div>
					</div>
				</div>
			</div>
			<?php elseif($v["works_type"] == 2): ?>
			<div class="feed-item">
				<div class="feed-user-info">
					<a href=""><img src="<?php echo get_user($pdo,"usericon", $v["user_id"]);?>" alt=""></a>
					<span class="user-name">
						<a href=""><?php echo get_user($pdo,"username", $v["user_id"]);?></a>
					</span>
					赞了一首Ting
					<span class="time">
						<?php if((time() - $v["public_time"]) < 3600): ?>
								<?php echo floor((time() - $v["public_time"]) / 60);?> minutes ago
							<?php elseif((time() - $v["public_time"]) < 24*3600): ?>
								<?php echo floor((time() - $v["public_time"]) / (60*60));?> houre ago
							<?php elseif((time() - $v["public_time"]) < 30*24*3600): ?>
								<?php echo floor((time() - $v["public_time"]) / (60*60*24));?> day ago
							<?php endif; ?>
					</span>
				</div>
				<div class="feed-title">
					<a href="detail.php?w_id=<?php echo $v["works_id"]."&w_type=".$v["works_type"];?>"><?php echo $v["title"];?></a>
				</div>
				<div class="feed-contend feed-ting">
					<div class="ting-img">
						<a href="" target="_blank"><img src="<?php echo $v["img_pic"];?>" width="100%" height="100%"></a>
					</div>
					<div class="ting-box">
						<div class="ting-content">
							<?php echo $v["content"];?>
							
						</div>
						<div class="feed-user-name"><a href="" target="_blank">主播:南夏-</a></div>
						<div class="feed-others"><?php echo $v["view"];?>次播放&nbsp;&nbsp;|&nbsp;&nbsp;评论:<?php echo comment_count($pdo, $v["works_id"]);?>&nbsp;&nbsp;|&nbsp;&nbsp;喜欢:<?php echo $v["zan"];?>
						</div>
					</div>
				</div>
			</div>
			<?php  endif; ?>
		<?php endforeach; ?>

			<!-- <div class="feed-item">
				<div class="feed-user-info">
					<a href=""><img src="img/40.jpg" alt=""></a>
					<span class="user-name">
						<a href="">南夏-</a>
					</span>
					发布了一首Ting
					<span class="time">4 minutes ago</span>
				</div>
				<div class="feed-title">
					<a href="">你拥抱的,并不总是也拥抱你</a>
				</div>
				<div class="feed-contend feed-ting">
					<div class="ting-img">
						<a href="" target="_blank"><img src="http://hpimg.pianke.me/fdb967556fd12a3408c849624760c65920170811.jpg" width="100%"></a>
					</div>
					<div class="ting-box">
						<div class="ting-content">
							村上春树写道：“不知为何，恰如其分的话总是姗姗来迟，错过最恰当的时机。”&nbsp;你知道的对吧，很多次卡在心里的言语总时无法说出口，就像那场告别，明明希望有所挽留，可最后决绝离开。所有的变化都是在心里，任你在...
							<div class="feed-user-name" style="display: none;">
								<a href="" target="_blank">主播:南夏-</a>
							</div>
						</div>
						<div class="feed-others">1.2 k次播放&nbsp;&nbsp;|&nbsp;&nbsp;评论:6&nbsp;&nbsp;|&nbsp;&nbsp;喜欢:41
						</div>
					</div>
				</div>
			</div>
			
			<div class="feed-item">
				<div class="feed-user-info">
					<a href=""><img src="img/40.jpg" alt=""></a>
					<span class="user-name">
						<a href="">南夏-</a>
					</span>
					赞了一篇文章
					<span class="time">4 minutes ago</span>
				</div>
				<div class="feed-title">
					<a href="">夏天走了,我还没去看过海</a>
				</div>
				<div class="feed-contend feed-article">
			
					<div class="article-box article-no-img">
						<div class="article-content">
							我还是会想起我家的狗，即使它是我童年的一道阴影，但我还是会想它。它是条很尽职的狗，爷爷也很喜欢它。它总是和爷爷待在左边的护院里，爷爷总是坐在护院门边的桌子旁，...
							<span class="view-all">
								<a href="">VIEW ALL
									<img src="img/viewall.png" alt=""></a>
								</span>
								<div class="feed-user-name">
									<a href="">By/TwoX</a>
								</div>
							</div>
							<div class="feed-others">1.2 k次播放&nbsp;&nbsp;|&nbsp;&nbsp;评论:6&nbsp;&nbsp;|&nbsp;&nbsp;喜欢:41
							</div>
						</div>
						<div class="article-img">
							<a href="" target="_blank"><img src="" width="100%"></a>
						</div>
					</div>
				</div> -->
				
				


			</div>
			<div class="loading"></div>
			<div class="no-more-data" style="display: none;">-&nbsp;已加载全部&nbsp;-</div>
			<div class="back-top hidden"></div>
		</div>
		<footer></footer>
	</div>
</body>
</html>