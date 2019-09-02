<!-- sidebar start -->
<div class="admin-sidebar">
    <ul class="am-list admin-sidebar-list">
        <li><a href="{{url('index')}}"><span class="am-icon-home"></span> 首页</a></li>
        @foreach($menus ?? [] as $k=>$v)
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#{{$v['permissionName']}}'}"><span class="am-icon-file"></span> {{$v['permissionName']}} <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="{{$v['permissionName']}}">
                    @foreach($v['items'] ?? [] as $kk=>$vv)
                    <li><a href="{{url($vv['route'])}}"><span class="am-icon-puzzle-piece"></span> {{$vv['permissionName']}}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        <li><a href="{{route('logout')}}"><span class="am-icon-sign-out"></span> 注销</a></li>
    </ul>

    <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
            <p><span class="am-icon-bookmark"></span> 公告</p>
            <p>时光静好，与君语；细水流年，与君同。—— Amaze UI</p>
        </div>
    </div>

    <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
            <p><span class="am-icon-tag"></span> wiki</p>
            <p>Welcome to the Amaze UI wiki!</p>
        </div>
    </div>
</div>
<!-- sidebar end -->