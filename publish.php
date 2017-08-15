<?php

	include_once "fun.php";
	
	
	if(!judgeLogin()){
		msg(0, "请登录", "reg.php");
	}else{
		
		$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");
		/*文章部分*/
		if(!empty($_POST["wz_title"])){
			$works_type = $_POST["works_type"];//作品类型
			$wz_title = s_str($_POST["wz_title"]);//文章标题
			$wz_file = $_FILES["file"];//文章图片
			$wz_cont = s_str($_POST["wz_cont"]);//文章内容
			// print_r($wz_cont);die;
			$user_id = get_user_id();
			$img_url = upload($wz_file, $user_id);
			// print_r($img_url);
			$public_time = time();
			$result = $pdo->exec("insert into works(title, content, img_pic, works_type, user_id, public_time, zan, view) values('{$wz_title}', '{$wz_cont}', '{$img_url}', {$works_type}, {$user_id}, {$public_time}, 0, 0)");
			/*if($result){
				msg(1, "操作成功！", "user.php");
			}else{
				msg(0, "发布失败！");
			}*/
			s_or_l($result);
		}
		//Ting部分
		if(!empty($_POST["t_title"])){
			$works_type = $_POST["works_type"];//作品类型
			$t_title = s_str($_POST["t_title"]);//Ting标题
			$t_file = $_FILES["file2"];//Ting图片
			$t_sound = $_FILES["t_sound"];//Ting音乐
			// print_r($t_sound);die;
			$t_cont = s_str($_POST["t_cont"]);//Ting内容
			$user_id = get_user_id();
			$img_url = upload($t_file, $user_id);//返回图片访问地址
			$sound_url = upload($t_sound, $user_id, 1);//返回声音访问地址
			// print_r($img_url);
			$public_time = time();
			$result = $pdo->exec("insert into works(title, content, img_pic, works_type, user_id, music_pic,public_time, zan, view) values('{$t_title}', '{$t_cont}', '{$img_url}', {$works_type}, {$user_id}, '{$sound_url}', {$public_time}, 0, 0)");
			// var_dump($result);
			/*if($result){
				msg(1, "操作成功！", "user.php");
			}else{
				msg(0, "发布失败！");
			}*/
			s_or_l($result);
		}
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>发布</title>
		<link rel="stylesheet" href="css/publish.css" />
		<link rel="stylesheet" href="css/base.css" />
		<link rel="stylesheet" href="css/text.css" />
		
	</head>
	<body>
		<!--左侧导航-->
		<div class="choice">
			<div class="logo">
				<a href="index.php" style="display: block;padding: 10px 0;"><img src="img/lo_go.png"/></a>
			</div>
			<ul>
				<li class="active_btn"><a href="javascript:void (0);" >文章</a></li>
				<li><a href="javascript:void (0);">Ting</a></li>
			</ul>
			<div class="face">
				<a href="user.php"><img style="width: 100%;" src="<?php echo $_SESSION["pkUser"]["usericon"]; ?>"/></a>
				<hr />
				<a href="">账号</a>
			</div>
		</div>
		<div class="t_all">
			<form action="publish.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="500000000000">
			<!--创建片刊-->
			<div class="test">
				<div class="test_t">
					<a href="javascript:void (0);">
						<img src="img/l12.png" alt="" />创建片刊
					</a>
				</div>
				<hr />
				<div class="cap">
					<input type="text" name="wz_title" id="" placeholder="请输入片刊名称"/>
					<!-- <span>取消</span><span>确定</span> -->
				</div>
				
				<!--<div class="test_b ">
					<a href="">未收录文章</a>
				</div>-->
			</div>
			<!--新建文章-->
			<div class="test_title">
				<div class="test_t">
					<a href="">
						<img src="img/l12.png" alt=""/>新建图片
					</a>
				</div>
				<div class="test_b ">
					<a href="">请选择图片<br /><span>刚刚</span></a>
					<img src="img/l14.png" alt="" width="14"/>
					<img src="img/l15.png" alt="" width="13"/>
				</div>
				<h3 style="font-size: 30px; margin-top: 50px; text-align: center;">图片上传</h3>
       		 	<div id="inputimg">添加图片附件
       		 		<input type="file" name="file">
       		 	</div>
       		 	<div id="preview" ></div>
			</div>
			<!--编辑文章-->
			<div class="content">
				<div class="box">
					<div class="box_top">
						<div class="preview">
							<a href=""><span>预览</span></a>
							<a href=""><span>立即发布</span></a>
						</div>
						<div class="input">
							<input type="text" name="" id="" value="" max-length="30"/>
							<span>7</span>/30
						</div>
					</div>
					<hr />
					<div class="box_bottom">
						<div class="catagray">
							<ul>
								<li><a href="">选择分类&nbsp&nbsp<img src="img/l16.png" alt="" /></a>
									<ul class="pull">
										<li>
											<a href="">早安故事</a>
											<a href="">晚安故事</a>
											<a href="">生活范</a>
											<a href="">奇妙物语</a>
											<a href="">浮世绘</a>
											<a href="">读心术</a>
											<a href="">破万卷</a>
											<a href="">审片室</a>
											<a href="">古诗远方</a>
											<a href="">片刻Talk</a>
											<a href="">在路上</a>
											<a href="">角</a>
											<a href="">视觉系</a>
											<a href="">片刻趴</a>
										</li>
									</ul>
									
								</li>
								<li><a href="">导入公众号文章</a></li>
								<li><a href="">添加音乐&nbsp&nbsp<img src="img/l17.png" alt="" /></a></li>
							</ul>
							<div class="choose">
								<a href="" class="active_c">原创</a><a href="">转载</a>
							</div>
						</div>
						<h2>文章内容</h2>
						<!--插件-->
						<div class="main">
							<!--<div class="header">
						    <div class="path">
						      <p>Articles</p>
						      <p id="articleHeaderName">Create New Article</p>
						    </div>
						    <div class="logo"></div>
						  </div>-->
							<!--<div class="sidebar">
						    <div class="circles"></div>
						    <div class="exitMenu">
						      <input type="checkbox" id="exitMenuCheckbox"/> 
						      <label for="exitMenuCheckbox"></label>
						      <div class="finishButton">
						        <a href="javascript:void(0);" id="publish">Publish</a>
						        <a href="javascript:void(0);" id="save">Save Draft</a>
						        <a href="javascript:void(0);" id="delete">Delete Draft</a>
						      </div>
						    </div>
						  </div>-->
							<div class="content">
								<!--<h1 contenteditable="true">Simple blog editor - A great way of learning</h1>-->
								<div class="textEditing">
						
									<input type="checkbox" id="bold"><label for="bold"><span class="fontawesome-bold"></span></label></input>
									<input type="checkbox" id="italic"><label for="italic"><span class="fontawesome-italic"></span></label></input>
									<input type="checkbox" id="underline"><label for="underline"><span class="fontawesome-underline"></span></label></input>
									<input type="radio" name="textStyle" id="left" checked><label for="left"><span class="fontawesome-align-left"></span></label></input>
									<input type="radio" name="textStyle" id="center"><label for="center"><span class="fontawesome-align-center"></span></label></input>
									<input type="radio" name="textStyle" id="right"><label for="right"><span class="fontawesome-align-right"></span></label></input>
									<input type="radio" name="textStyle" id="justify"><label for="justify"><span class="fontawesome-align-justify"></span></label></input>
									<input type="file" id="image"><label for="image"><span class="fontawesome-picture"></span></label></input>
									<input type="checkbox" id="attachment"><label for="attachment"><span class="fontawesome-link"></span></label></input>
									<input type="" id="link"><label for="link" id="linkLable"><span id=""></span></label></input>
									<input type="checkbox" id="code"><label for="code"><span class="fontawesome-quote-right"></span></label></input>
								</div>
								<p id="contentText" contenteditable="true">Enter text here</p>
							</div>
						</div>
						<input type="hidden" name="wz_cont" id="wz_cont" value="">
						<input type="hidden" name="works_type" id="works_type" value="1">
						<input type="submit" name="publish" id="publish" value="立即发布"/>
					</div>
				</div>
			</div>
		</form>

			
		
		
		<!--音乐上传-->
		<form action="publish.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="500000000000">
			<!--创建片刊-->
			<div class="test">
				<div class="test_t">
					<a href="">
						<img src="img/l12.png" alt="" />创建片刊
					</a>
				</div>
				<hr />
				<div class="cap">
						<input type="text" name="t_title" id="" placeholder="请输入片刊名称"/>
						<!-- <span>取消</span><span>确定</span> -->
				</div>
				
			</div>
			<!--新建Ting-->
			<div class="test_title">
				<div class="test_t">
					<a href="">
						<img src="img/l18.png" alt="" style="width:31px;"/>新建Ting
					</a>
				</div>
				<div class="lable">
					<h3>编辑封面</h3>
					<div id="inputimg2">添加图片附件
       		 			<input type="file" name="file2">
       		 		</div>
       		 		<div id="preview2" ></div>
				</div>
			</div>
			<!--编辑文章-->
			<div class="content">
				<div class="box">
					<div class="box_t">
						<input type="file" name="t_sound" id="mfile" />
						<span>上传音频文件</span>
						<p>文件暂时只支持mp3、ogg、wav格式  文件大小不能超过5M</p>
					</div>
					<hr />
					<div class="box_bottom">
						<h3>内容编辑：</h3>
						<!--插件引入-->
						<div class="main">
							<!--<div class="header">
						    <div class="path">
						      <p>Articles</p>
						      <p id="articleHeaderName">Create New Article</p>
						    </div>
						    <div class="logo"></div>
						  </div>-->
							<!--<div class="sidebar">
						    <div class="circles"></div>
						    <div class="exitMenu">
						      <input type="checkbox" id="exitMenuCheckbox"/> 
						      <label for="exitMenuCheckbox"></label>
						      <div class="finishButton">
						        <a href="javascript:void(0);" id="publish">Publish</a>
						        <a href="javascript:void(0);" id="save">Save Draft</a>
						        <a href="javascript:void(0);" id="delete">Delete Draft</a>
						      </div>
						    </div>
						  </div>-->
							<div class="content">
								<!--<h1 contenteditable="true">Simple blog editor - A great way of learning</h1>-->
								<div class="textEditing">
						
									<input type="checkbox" id="bold"><label for="bold"><span class="fontawesome-bold"></span></label></input>
									<input type="checkbox" id="italic"><label for="italic"><span class="fontawesome-italic"></span></label></input>
									<input type="checkbox" id="underline"><label for="underline"><span class="fontawesome-underline"></span></label></input>
									<input type="radio" name="textStyle" id="left" checked><label for="left"><span class="fontawesome-align-left"></span></label></input>
									<input type="radio" name="textStyle" id="center"><label for="center"><span class="fontawesome-align-center"></span></label></input>
									<input type="radio" name="textStyle" id="right"><label for="right"><span class="fontawesome-align-right"></span></label></input>
									<input type="radio" name="textStyle" id="justify"><label for="justify"><span class="fontawesome-align-justify"></span></label></input>
									<input type="file" id="image"><label for="image"><span class="fontawesome-picture"></span></label></input>
									<input type="checkbox" id="attachment"><label for="attachment"><span class="fontawesome-link"></span></label></input>
									<input type="" id="link"><label for="link" id="linkLable"><span id=""></span></label></input>
									<input type="checkbox" id="code"><label for="code"><span class="fontawesome-quote-right"></span></label></input>
								</div>
								<!-- <p id="contentText2" contenteditable="true">Enter text here</p> -->
								<textarea id="cont2" name="t_cont" cols="30" rows="10" style="
    background: white; box-shadow: inset 0px 0px 4px -1px rgb(162, 148, 148);">Enter text here</textarea>
							</div>
						</div>
						<input type="hidden" name="works_type" class="works_type" value="1">
						<input type="hidden" name="t_content" id="t_content" value="">
						<input type="submit" name="r_publish" id="r_now" value="立即发布"/>
					</div>
				</div>
			</div>
		</form>
		</div>
		
	</body>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/prefixfree.min.js"></script>
	<script src="js/text.js"></script>
	<script src="js/index.js"></script>
	<script>
	$("#contentText").keyup(function(){
		$("#wz_cont").val($("#contentText").html());
	});
	$("#contentText2").keyup(function(){
		$("#wz_cont").val($("#contentText2").html());
	});
	// console.log($(".choice ul li").index());

	</script>
</html>
