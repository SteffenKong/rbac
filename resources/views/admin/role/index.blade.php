@extends('admin.components.base')

@section('content')
  <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">角色列表</strong></div>
    </div>

    <div class="am-g">
      <div class="col-md-6 am-cf">
        <div class="am-fl am-cf">
          <div class="am-btn-toolbar am-fl">
            <div class="am-btn-group am-btn-group-xs">
              <button type="button" class="am-btn am-btn-default" onclick="window.location.href='/role/add';"><span class="am-icon-plus"></span> 新增</button>
            </div>

            <div class="am-form-group am-margin-left am-fl">

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 am-cf">
        <div class="am-fr">
            <form action="{{url('/role/index')}}" method="get">
          <div class="am-input-group am-input-group-sm">
            <input type="text" name="roleName" class="am-form-field">
            <span class="am-input-group-btn">
                  <button class="am-btn am-btn-default" type="submit">搜索</button>
                </span>
          </div>
            </form>
        </div>
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
              <th class="table-title">角色名称</th>
              <th class="table-type">描述</th>
              <th class="table-author">状态</th>
              <th class="table-date">录入日期</th>
              <th class="table-date">修改日期</th>
              <th class="table-set">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list[1] as $k=>$v)
              <tr>
                <td><input type="checkbox" /></td>
                <td>{{$v['id']}}</td>
                <td><a href="#">{{$v['roleName']}}</a></td>
                <td><a href="javascript:;" class="checkDescription" data-content="{{$v['description']}}">点击查看描述</a></td>
                <td>
                    @if($v['status'] == 0)
                      <a href="javascript:;" data-id="{{$v['id']}}" onclick="changeStatus($(this))"  class="am-btn am-btn-danger am-btn-xs">禁用</a>
                      @else
                    <a href="javascript:;"  data-id="{{$v['id']}}" onclick="changeStatus($(this))"  class="am-btn am-btn-success am-btn-xs">启用</a>
                   @endif
                </td>
                <td>{{$v['createdAt']}}</td>
                <td>{{$v['updatedAt']}}</td>
                <td>
                    <div class="am-btn-group am-btn-group-xs">
                      <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="window.location.href='/role/edit/{{$v['id']}}';">
                        <span class="am-icon-pencil-square-o"></span> 编辑</button>

                      <button type="button" data-id="{{$v['id']}}" class="am-btn am-btn-default am-btn-xs am-text-secondary dirbute" >
                        <span class="am-icon-pencil-square-o" id="doc-prompt-toggle"></span> 分配权限 </button>

                      <button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger" data-id="{{$v['id']}}" onclick="deleteData($(this))"><span class="am-icon-trash-o"></span> 删除</button>
                    </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <div class="am-cf">
            共 {{$list[0]->total()}} 条记录
            <div class="am-fr">
              {{$list[0]->render()}}
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

      $(".dirbute").click(function() {
          let id = $(this).attr('data-id');
          if(id == '') {
              layer.msg('id不能为空',{icon:2});
          }
          layer.open({
              type: 2,
              title:'分配权限',
              content: '/role/dirbutePermissionView?id='+id,
              area: ['500px', '400px'],
              success: function(layero, index){
                  var body = layer.getChildFrame('body', index);
                  var iframeWin = window[layero.find('iframe')[0]['name']];
              }
          });
      });



      function changeStatus(obj) {
              let id = $(obj).attr('data-id');
              if(id === '') {
                  alert('id非法');
              }

              $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
              });

              $.ajax({
                  url:'/role/changeStatus',
                  dataType:'Json',
                  type:'POST',
                  data:{id:id},
                  success:function(data) {
                      if(data.code === '000') {
                           window.location.reload();
                      }else {
                          alert(data.message);
                      }
                  }
              });
      }


      /**
       *
       * @param obj
       * 删除
       */
      function deleteData(obj) {

          if(window.confirm('请问真的要删除吗') == false) {
              return false;
          }

          let id = $(obj).attr('data-id');
          if(id == '') {
            alert('id非法');
          }

        $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN' : $("meta[name='token']").attr('content') }
        });

        $.ajax({
          url:'/role/delete',
          dataType:'Json',
          type:'delete',
          data:{id:id},
          success:function(data) {
            if(data.code === '000') {
              window.location.reload();
            }else {
              alert(data.message);
            }
          }
        });
      }

      $('#doc-prompt-toggle').on('click', function() {
          $('#my-prompt').modal({
              relatedElement: this,
              onConfirm: function(data) {
                  alert('你输入的是：' + data)
              },
              onCancel: function() {
                  alert('不想说!');
              }
          });
      });


      //点击显示描述内容
      $(".checkDescription").click(function() {
          let content = $(this).attr('data-content');
          layer.open({
              title: '角色描述',
              area: ['400px', '300px'],
              content: content
          });
      });
  </script>
@endsection