//设置阻止表单提交
$("form").submit(function() {
    return false;
});


//登录动作
$(".sign").click(function() {
    let account = $("#account").val();
    let password = $("#password").val();
    let captcha = $("#captcha").val();

    let flag = true;

    if(account == '') {
        layer.msg('请填写用户名',{icon:2});
        flag = false;
    }

    if(password == '') {
        layer.msg('请填写密码',{icon:2});
        flag = false;
    }

    if(captcha == '') {
        layer.msg('请填写验证码',{icon:2});
        flag = false;
    }

    if(flag === false) {
        return false;
    }


});



//获取验证码接口
