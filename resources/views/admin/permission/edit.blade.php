@extends('admin.components.base')

@section('content')

    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">权限编辑</strong> / <small>Permission Edit</small></div>
        </div>

        <hr/>

        <div class="am-g">

            <div class="col-sm-12 col-md-4 col-md-push-8">



            </div>

            <div class="col-sm-12 col-md-8 col-md-pull-4">
                <form class="am-form am-form-horizontal">
                    <div class="am-form-group">
                        <label for="user-name" class="col-sm-3 am-form-label">权限名称</label>
                        <div class="col-sm-9">
                            <input type="text" name="permissionName" value="{{$oldPermission['permission_name']}}" id="user-name" placeholder="请输入权限名">

                        </div>
                    </div>


                    <div class="am-form-group">
                        <label for="user-name" class="col-sm-3 am-form-label">权限路由url</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{$oldPermission['url']}}" name="url" id="user-name">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="doc-select-1" class="col-sm-3 am-form-label">所属上级权限</label>
                        <div class="col-sm-9">
                            <select id="doc-select-1" name="pid">
                                <option value="0">父级权限</option>
                                @foreach($permissions as $key=>$value)
                                    @if($value['id'] == $oldPermission['pid'])
                                        <option value="{{$value['id']}}" selected="selected">|{{str_repeat('--',$value['level'])}}{{$value['permissionName']}}</option>
                                    @else
                                        <option value="{{$value['id']}}">|{{str_repeat('--',$value['level'])}}{{$value['permissionName']}}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        <span class="am-form-caret"></span>
                    </div>


                    <div class="am-form-group">
                        <div class="col-sm-9 col-sm-push-3">
                            <button type="button" class="am-btn am-btn-primary" id="editBtn" style="width:150px; margin-top:30px;">编辑</button>
                            <input type="hidden" name="id" value="{{$oldPermission['id']}}" />
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
                    url:'/permission/edit',
                    type:'put',
                    dataType:'Json',
                    data:data,
                    success:function(data) {
                        if(data.code === '000') {
                            layer.msg(data.message,{icon:1});
                            window.setInterval(function() {
                                window.location.href = '/permission/index';
                            },1000)
                        }else if (data.code === '001') {
                            layer.msg(data.message,{icon:2});
                        }else {
                            console.log(data);
                            let errors = data.errors;
                            $.each(errors,function(k,v) {
                                layer.msg(v[0],{icon:2});
                            });
                        }
                    }
                });
            })
        })
    </script>

@endsection
