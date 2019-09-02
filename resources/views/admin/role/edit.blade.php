@extends('admin.components.base')

@section('content')

<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">角色编辑</strong> / <small>Role Add</small></div>
    </div>

    <hr/>

    <div class="am-g">

        <div class="col-sm-12 col-md-4 col-md-push-8">



        </div>

        <div class="col-sm-12 col-md-8 col-md-pull-4">
            <form class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="user-name" class="col-sm-3 am-form-label">角色名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="roleName" value="{{$data['roleName']}}" id="user-name" placeholder="请输入角色名">

                    </div>
                </div>




                <div class="am-form-group">
                    <label for="user-weibo" class="col-sm-3 am-form-label">描述</label>
                    <div class="col-sm-9">
                    <textarea class="" rows="5" name="description" id="doc-ta-1">{{$data['description']}}</textarea>
                    </div>
                </div>


        <div class="am-checkbox">
            <label for="demo" class="col-sm-3 am-form-label" >状态</label>
                <div class="col-sm-9">
                    @if($data['status'] == 0)
                        <input type="checkbox" checked="checked" name="status" value="0" id="demo"> 禁用

                    @else
                        <input type="checkbox" name="status" value="0" id="demo"> 禁用
                    @endif
                </div>
        </div>

                <div class="am-form-group">
                    <div class="col-sm-9 col-sm-push-3">
                        <button type="button" class="am-btn am-btn-primary" id="editBtn" style="width:150px; margin-top:30px;">编辑</button>
                        <input type="hidden" name="id" value="{{$data['id']}}" />
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
            $("#editBtn").click(function() {
                let data = $("form").serialize();

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
                });

                $.ajax({
                    url:'/role/edit',
                    type:'put',
                    dataType:'Json',
                    data:data,
                    success:function(data) {
                        if(data.code === '000') {
                            // layer.msg(data.message,{icon:1});
                            alert(data.message);
                            window.setInterval(function() {
                                window.location.href = '/role/index';
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
