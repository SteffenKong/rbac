@extends('admin.components.base')

@section('content')

<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">账号添加</strong> / <small>Account Add</small></div>
    </div>

    <hr/>

    <div class="am-g">

        <div class="col-sm-12 col-md-4 col-md-push-8">



        </div>

        <div class="col-sm-12 col-md-8 col-md-pull-4">
            <form class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="user-name" class="col-sm-3 am-form-label">账号</label>
                    <div class="col-sm-9">
                        <input type="text" name="account" id="user-name" placeholder="请输入账号">

                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-QQ" class="col-sm-3 am-form-label">密码</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" placeholder="请输入密码">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-email" class="col-sm-3 am-form-label">电子邮件</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" id="user-email" placeholder="输入你的电子邮件">

                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-phone" class="col-sm-3 am-form-label">手机号码</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" id="user-phone" placeholder="输入你的手机号码">
                    </div>
                </div>



                <div class="am-form-group">
                    <label for="user-weibo" class="col-sm-3 am-form-label">真实姓名</label>
                    <div class="col-sm-9">
                        <input type="text" name="nickName" id="user-weibo" placeholder="输入你的真实姓名">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-intro" class="col-sm-3 am-form-label">状态</label>
                    <div class="col-sm-9">
                        <div class="am-btn-group" data-am-button>
                            <label class="am-btn am-btn-primary">
                                <input type="checkbox" name="status" value="0">禁用
                            </label>
                        </div>
                    </div>
                </div>


                <div class="am-form-group">
                    <label for="user-intro" class="col-sm-3 am-form-label">角色</label>
                    <div class="col-sm-9">
                                <div class="am-btn-group" data-am-button>
                                    <label class="am-btn am-btn-primary">
                                        <input type="radio" name="roleId" id="option1" value="0">超级管理员
                                    </label>
                                </div>
                    </div>
                </div>

                <div class="am-form-group">
                    <div class="col-sm-9 col-sm-push-3">
                        <button type="button" class="am-btn am-btn-primary" id="addBtn" style="width:150px; margin-top:30px;">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- content end -->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $("#addBtn").click(function() {
                let data = $("form").serialize();

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
                });

                $.ajax({
                    url:'/admin/add',
                    type:'post',
                    dataType:'Json',
                    data:data,
                    success:function(data) {
                        if(data.code === '000') {
                            // layer.msg(data.message,{icon:1});
                            alert(data.message);
                            window.setInterval(function() {
                                window.location.href = '/admin/index';
                            },1000)
                        }else if (data.code === '001') {
                            // layer.msg(data.message,{icon:2});
                            alert(data.message);
                        }else {
                            console.log(data);
                            let errors = data.errors;
                            $.each(errors,function(k,v) {
                                // layer.msg(v[0],{icon:2});
                                alert(v[0]);
                            });
                        }
                    }
                });
            })
        })
    </script>

@endsection
