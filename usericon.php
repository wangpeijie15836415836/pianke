<?php
include_once "fun.php";

if(!judgeLogin()){
	msg(0, "请登录", "reg.php");
}else{
	// session_start();
	
	// session_start();
	// $user_id = $_SESSION["pkUser"]["id"];

	$user_id =  get_user_id();

	
	/*前台传入base64位图片，转换为jpg图片，返回图片路径*/
	if(isset($_POST["base64img"])){
		$img = $_POST["base64img"];
		$imageurl = setIcon($img);
		echo $imageurl;
	}
	// var_dump(file_exists($_POST["img_url"]));die;
	/*post接收数据，对数据进行存储,当$img_url设置值并且存在的情况下向下执行*/
	// if(!empty($_POST["img_url"]) && file_exists($_POST["img_url"])){
	if(!empty($_POST["img_url"])){
		$img_url = trim($_POST["img_url"]);//接收用户头像临时存放路径usericon/598d7582eb6c3131.jpg
//		$_SESSION["times"] = 500;
		// echo $img_url;die;
		$user_words = trim($_POST["user_words"]);//接收用户简介
		// echo $user_words;die;
		
		
		$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");//连接数据库
		
		$imgUrl = userIcon($img_url, $user_id);//上传用户头像，返回用户头像的访问路径http://localhost/PHP/PianKe/file/33/2017/0811/598d797b109a1132.jpg	
//		 echo $imgUrl;die;
		if($imgUrl){
			$result = $pdo->exec("update user set usericon = '{$imgUrl}', userwords = '{$user_words}' where id = {$user_id}");//更新数据库
			updataSession($user_id, $pdo);
//			var_dump($result);die;
//			print_r($_SESSION);die;

		}else{
			$result = $pdo->exec("update user set userwords = '{$user_words}' where id = {$user_id}");//更新数据库
			updataSession($user_id, $pdo);
			
		}
		msg(1, "修改成功", "user.php");
		
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户资料</title>
	<script src="js/jquery-1.10.2.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-3.3.4.css">
	<script src="js/bootstrap-3.3.4.js"></script>
	<script src="js/cropper.js"></script>
	<script src="js/sitelogo.js"></script>
	<link href="css/cropper.min.css" rel="stylesheet">
	<link href="css/sitelogo.css" rel="stylesheet">
	<style type="text/css">
		.avatar-btns button {
			height: 35px;
		}

	</style>

	<link rel="stylesheet" href="css/usericon.css">
</head>
<body>
	<header>
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
				<div class="userinfo1">
					<a href="user.php">
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
	<div class="cont">
		<div class="usericon">
			<img src="<?php echo $_SESSION["pkUser"]["usericon"];?>" alt="">
		</div>
		<div class="iconBtn">
			<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#avatar-modal" style="margin: 10px;">
				修改头像
			</button>
			<div class="user_pic" style="margin: 10px;">
				<img src=""/>
			</div>

			<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<!--<form class="avatar-form" action="upload-logo.php" enctype="multipart/form-data" method="post">-->
						<form class="avatar-form">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" type="button">&times;</button>
								<h4 class="modal-title" id="avatar-modal-label">上传图片</h4>
							</div>
							<div class="modal-body">
								<div class="avatar-body">
									<div class="avatar-upload">
										<input class="avatar-src" name="avatar_src" type="hidden">
										<input class="avatar-data" name="avatar_data" type="hidden">
										<label for="avatarInput" style="line-height: 35px;">图片上传</label>
										<button class="btn btn-danger"  type="button" style="height: 35px;" onclick="$('input[id=avatarInput]').click();">请选择图片</button>
										<span id="avatar-name"></span>
										<input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file">
									</div>

									<div class="row">
										<div class="col-md-9">
											<div class="avatar-wrapper"></div>
										</div>
										<div class="col-md-3">
											<div class="avatar-preview preview-lg" id="imageHead"></div>
											<!--<div class="avatar-preview preview-md"></div>
											<div class="avatar-preview preview-sm"></div>-->
										</div>
									</div>

									<div class="row avatar-btns">
										<div class="col-md-4">
											<div class="btn-group">
												<button class="btn btn-danger fa fa-undo" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">向左旋转</button>
											</div>
											<div class="btn-group">
												<button class="btn  btn-danger fa fa-repeat" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">向右旋转</button>
											</div>
										</div>

										<div class="col-md-5" style="text-align: right;">								
											<button class="btn btn-danger fa fa-arrows" data-method="setDragMode" data-option="move" type="button" title="移动">移动
												<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
												</span>
											</button>
											<button type="button" class="btn btn-danger fa fa-search-plus" data-method="zoom" data-option="0.1" title="放大图片">+
												<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
													<!--<span class="fa fa-search-plus"></span>-->
												</span>
											</button>
											<button type="button" class="btn btn-danger fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片">-
												<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
													<!--<span class="fa fa-search-minus"></span>-->
												</span>
											</button>
											<button type="button" class="btn btn-danger fa fa-refresh" data-method="reset" title="重置图片">重置
												<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;reset&quot;)" aria-describedby="tooltip866214"></span>
											</button>
										</div>

										<div class="col-md-3">
											<button class="btn btn-danger btn-block avatar-save fa fa-save" type="button" data-dismiss="modal">保存修改</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
		</div>
		
			<div id="words">
				<form action="usericon.php" method="post">
					简介：<textarea name="user_words" id="userwords" ><?php echo $_SESSION["pkUser"]["userwords"];?></textarea>
					<input type="hidden" id="img_url" name="img_url" value="<?php echo $_SESSION["pkUser"]["usericon"];?>">
					<input type="submit" id="usericon_submit" value="保存设置" >
				</form>
			</div>
		
		<!-- <button id="usericon_submit">保存设置</button> -->
	</div>
	<script src="js/html2canvas.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	//做个下简易的验证  大小 格式 
	// console.log($("#img_url").val());
	$('#avatarInput').on('change', function(e) {
			var filemaxsize = 1024 * 5;//5M
			var target = $(e.target);
			var Size = target[0].files[0].size / 1024;
			if(Size > filemaxsize) {
				alert('图片过大，请重新选择!');
				$(".avatar-wrapper").childre().remove;
				return false;
			}
			if(!this.files[0].type.match(/image.*/)) {
				alert('请选择正确的图片!')
			} else {
				var filename = document.querySelector("#avatar-name");
				var texts = document.querySelector("#avatarInput").value;
				var teststr = texts; //你这里的路径写错了
				testend = teststr.match(/[^\\]+\.[^\(]+/i); //直接完整文件名的
				filename.innerHTML = testend;
			}

		});

	$(".avatar-save").on("click", function() {
		var img_lg = document.getElementById('imageHead');
			// 截图小的显示框内的内容
			html2canvas(img_lg, {
				allowTaint: true,
				taintTest: false,
				onrendered: function(canvas) {
					canvas.id = "mycanvas";
					//生成base64图片数据
					var dataUrl = canvas.toDataURL("image/jpeg");
					var newImg = document.createElement("img");
					newImg.src = dataUrl;
					imagesAjax(dataUrl)
				}
			});
		})

	function imagesAjax(src) {
		var data = {};
		data.img = src;
		data.jid = $('#jid').val();
		var base64img = data.img.split("data:image/jpeg;base64,");
			// console.log(base64img);
			$.ajax({
				url: "usericon.php",
				data: {"base64img":base64img[1]},
				type: "POST",
				// dataType: 'json',
				success: function(data,re) {
					// console.log(data);
					var imgurl = data.split("<!DOCTYPE html>");
					if(re.status == '1') {
						$('.user_pic img').attr('src',src );
					}
					$(".usericon img").attr("src",imgurl[0]);
					$("#img_url").attr("value",$(".usericon img").attr("src"));
					// console.log($("#img_url").val());
				}
			});
		}
	</script>

	</body>
	</html>