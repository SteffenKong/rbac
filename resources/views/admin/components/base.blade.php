<!doctype html>
<html class="no-js">
<head>
  {{--引入meta资源--}}
  @include('admin.components.meta')
</head>
<body>

{{--引入头部--}}
@include('admin.components.header')

<div class="am-cf admin-main">

  {{--引入左侧工具栏--}}
  @include('admin.components.menu')


  {{--这里存放内容--}}
  @yield('content')

</div>

@include('admin.components.footer')

@include('admin.components.scripts')

@yield('script')
</body>
</html>
