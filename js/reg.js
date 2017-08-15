$(function(){
    $(".swiper-container").css("height",$(document).height());
    var mySwiper = new Swiper ('.swiper-container', {
        direction: 'vertical',
        loop: true,
        effect : 'fade',
        autoplay: 5000, //自动切换的时间间隔（ms）
        speed: 1500, //播放速度
        autoplayDisableOnInteraction: false,
    });

    $('.nav li').on("click",function() {
        $('.nav li').removeClass('active');
        $(this).addClass('active');
        $('.content').removeClass('show').eq($(this).index()).addClass('show');
    });

    //验证注册表单
    $('#reg_form').submit(function () {
        var user = $('#user').val(),
        password = $('#password').val(),
        password1 = $('#password1').val();
        if (user == '' || user.length <= 0) {
            layer.tips('用户名不能为空', '#user', {time: 2000, tips: 2});
            $('#user').focus();
            return false;
        }

        if (password == '' || password.length <= 0) {
            layer.tips('密码不能为空', '#password', {time: 2000, tips: 2});
            $('#password').focus();
            return false;
        }
        if (password1 == '' || password1.length <= 0 || (password != password1)) {
            layer.tips('两次密码不一致', '#password1', {time: 2000, tips: 2});
            $('#password1').focus();
            return false;
        }
        return true;
    });
    
    //验证登录表单
    $('#login_form').submit(function () {
        var user = $('#user_l').val(),
        password = $('#password_l').val();
        if (user == '' || user.length <= 0) {
            layer.tips('用户名不能为空', '#user_l', {time: 2000, tips: 2});
            $('#user_l').focus();
            return false;
        }

        if (password == '' || password.length <= 0) {
            layer.tips('密码不能为空', '#password_l', {time: 2000, tips: 2});
            $('#password_l').focus();
            return false;
        }
        return true;
    });

});