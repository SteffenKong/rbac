<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="token" content="{!! csrf_token() !!}" />
    <link rel="stylesheet" type="text/css" href="https://www.layuicdn.com/layui-v2.5.4/css/layui.css" />
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/layer/2.3/layer.js"></script>
    <script type="text/javascript" src="https://www.layuicdn.com/layui-v2.5.3/layui.js"></script>
</head>
<body>
<form class="layui-form" onsubmit="return false;">
    <div class="layui-form-item">
        <label class="layui-form-label">权限</label>
        <div class="layui-input-block">
            @foreach($permissions as $key=>$permission)
                @if(in_array($permission['id'],$oldPermissionIds))
                    <input type="checkbox" name="permissionIds[]"  value="{{$permission['id']}}" title="{{$permission['permissionName']}}" lay-skin="primary" checked>
                    <br/>
                @else
                    <input type="checkbox" name="permissionIds[]" value="{{$permission['id']}}" title="{{$permission['permissionName']}}" lay-skin="primary">
                    <br/>
                @endif
            @endforeach
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" id="dirbute" lay-filter="formDemo">立即提交</button>
            <input type="hidden" name="id" value="{{$roleId}}" />
        </div>
    </div>
</form>
</body>
</html>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });

    $("#dirbute").click(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
        });
        $.ajax({
            url:'/role/dirbutePermission',
            dataType:'json',
            type:'post',
            data:$("form").serialize(),
            success:function(data) {
                if(data.code === '000'){
                    layer.msg(data.message,{icon:1});
                }else if (data.code === '001') {
                    layer.msg(data.message,{icon:2});
                }else {
                    layer.msg(data.message,{icon:2});
                }
            }
        });
    })
</script>