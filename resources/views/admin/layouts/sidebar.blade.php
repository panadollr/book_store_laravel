 <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
<script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>
  <body>
   
  <style type="text/css">
    body{
      font-size: 2.2ch;
      background: #DCDCDC;
    }
  </style>
 <div class="ui left demo visible vertical inverted blue sidebar labeled icon menu" >
  <a id="all" href="{{URL::to('admin/tong_quan')}}" class="item">
  <i class="user shield icon"></i>
    Tổng quan
  </a>
 <a id="a0" href="{{URL::to('admin/publishers')}}" class="item">
    <i class="block layout icon"></i>
    Bảng nhà xuất bản
  </a>

  <a id="a1" href="{{URL::to('admin/books')}}" class="item">
    <i class="book open icon"></i>
    Bảng sản phẩm
  </a>
  <a id="a2" href="{{URL::to('admin/orders')}}" class="item">
      <i class="clipboard icon"></i>
    Đơn hàng
  </a>
  <a id="a5" href="{{URL::to('admin/comments')}}" class="item">
  <i class="comments icon"></i>
    Bình luận
  </a>
  <a id="a4" class="item" href="{{URL::to('/admin/logout')}}" >
  <i class="sign out alternate icon"></i>đăng xuất</a>
</div>
</body>

 @if(\Session::has('success'))
<script >
   $('body')
  .toast({
     class: 'success',
    message: ' {{\Session::get('success') }}',
  });
  </script>
@endif

 @if($errors->any())
@foreach($errors->all() as $error)
<script > 
   $('body')
  .toast({
     class: 'error',
    message: '{{$error}}',
    showProgress: 'bottom',
  })
;
  </script>
@endforeach
@endif