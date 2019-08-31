@extends('admin.components.base')

@section('content')
  <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">权限列表</strong></div>
    </div>

    <div class="am-g">
      <div class="col-md-6 am-cf">
        <div class="am-fl am-cf">
          <div class="am-btn-toolbar am-fl">
            <div class="am-btn-group am-btn-group-xs">
              <button type="button" class="am-btn am-btn-default" onclick="window.location.href='/permission/add';"><span class="am-icon-plus"></span> 新增</button>
            </div>

            <div class="am-form-group am-margin-left am-fl">

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 am-cf">

      </div>
    </div>

    <div class="am-g">
      <div class="col-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main">
            <thead>
            <tr>
              <th class="table-check"><input type="checkbox" /></th>
              <th class="table-id">ID</th>
              <th class="table-title">权限名称</th>
              <th class="table-type">路由地址</th>
              <th class="table-author">所属权限</th>
              <th class="table-date">录入日期</th>
              <th class="table-date">修改日期</th>
              <th class="table-set">操作</th>
            </tr>
            </thead>
            <tbody>
                @foreach($list[0] as $k=>$v)
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td>{{$v['id']}}</td>
                    <td><a href="#">{{$v['permissionName']}}</a></td>
                    <td><a href="#">{{$v['url']}}</a></td>
                    <td><a href="#">{{$v['pid']}}</a></td>
                    <td>{{$v['createdAt']}}</td>
                    <td>{{$v['updatedAt']}}</td>
                    <td>
                        <div class="am-btn-group am-btn-group-xs">
                          <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="window.location.href='/permission/edit/{{$v['id']}}';">
                            <span class="am-icon-pencil-square-o"></span> 编辑</button>

                          <button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger" data-id="{{$v['id']}}" onclick="deleteData($(this))"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          <div class="am-cf">
            共 {{$list[1]}} 条记录
            <div class="am-fr">
            </div>
          </div>
          <hr />
        </form>
      </div>

    </div>
  </div>
  @include("admin.admin.changePass")
  <!-- content end -->
@endsection

@section('script')
  <script type="text/javascript">
      /**
       *
       * @param obj
       * 删除
       */
      function deleteData(obj) {

        if (window.confirm('请问真的要删除吗') == false) {
          return false;
        }

        let id = $(obj).attr('data-id');
        if (id == '') {
          alert('id非法');
        }

        $.ajaxSetup({
          headers: {'X-CSRF-TOKEN': $("meta[name='token']").attr('content')}
        });

        $.ajax({
          url: '/permission/delete',
          dataType: 'Json',
          type: 'delete',
          data: {id: id},
          success: function (data) {
            if (data.code === '000') {
              window.location.reload();
            } else {
              alert(data.message);
            }
          }
        });
      }
  </script>
@endsection