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

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
    });

    $.ajax({
        url:'sign',
        dataType:'Json',
        type:'POST',
        data:{account:account,password:password,captcha:captcha},
        success:function(data) {
            if(data.code === '000') {
                layer.msg('登陆成功',{icon:1});
                setInterval(function() {
                    window.location.href = '/index';
                },1000)
            }else if(data.code === '001') {
                layer.msg('登陆失败',{icon:2});
                refreshCaptcha($("#captcha_pic"));
            }else {
                let errors = data.errors;
                $.each(errors,function(k,v) {
                    layer.msg(v[0],{icon:2});
                });
                refreshCaptcha($("#captcha_pic"));
            }
        }
    });
});

//点击刷新验证码
$("#captcha_pic").click(function() {
    refreshCaptcha($(this));
});


function refreshCaptcha(obj) {
    let oldAddr = $(obj).attr('src');
    let newAddr = oldAddr+'/#/'+Math.random();
    $(obj).attr('src',newAddr);
}


//获取验证码接口
