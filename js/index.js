	//登录注册背景切换
//		var time1=null;
//		var i=0;
//		time1=setInterval(function(){
//			i++;
//			if(i>=$('.back img').length){
//				i=0;
//			}
//			$('.back img').eq(i).fadeIn(1500).siblings().fadeOut(1500);
//		},2000);
//	

	//按钮切换
//		$(" .con_r ul li").click(function(){
//			$(this).addClass("active").siblings().removeClass();
//			$(" .con_r .outer .form").eq($(this).index()).show().siblings().hide();
//		console.log($(this).index());
//	});

	//publish区
	var flag=true;
	$(".test .test_t").click(function(){
		if(flag){
			$(".cap").show();
			flag=false;
		}else{
			$(".cap").hide();
			flag=true;
		}
	})
	
	
	//文章区与音乐区的切换
	$(".choice ul li").click(function(){
		
		$(".works_type").val($(this).index() + 1);//将索引值传递给works_type
		$(this).addClass("active_btn").siblings().removeClass();
		$("form").eq($(this).index()).show().siblings().hide();
	});

	function preview1(file) {
            var img = new Image(), url = img.src = URL.createObjectURL(file)
            var $img = $(img)
            img.onload = function() {
                URL.revokeObjectURL(url)
                $('#preview').empty().append($img)
            }
        }
        $(function() {
            $('[name=file]').change(function(e) {
                var file = e.target.files[0]
                preview1(file)
            })
        })


        function preview2(file) {
            var img = new Image(), url = img.src = URL.createObjectURL(file)
            var $img = $(img)
            img.onload = function() {
                URL.revokeObjectURL(url)
                $('#preview2').empty().append($img)
            }
        }
         $(function() {
            $('[name=file2]').change(function(e) {
                var file = e.target.files[0]
                preview2(file)
            })
        })
         
        
	
	
