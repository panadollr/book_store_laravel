
<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/semantic.min.css') }}" >
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.2/dist/semantic.min.css">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="{{ asset('images/book_icon.png') }}" type="image/x-icon">
<title>{{ config('app.name') }}</title>

  <style type="text/css">

    .hidden.menu {
      display: none;
    }

    .masthead.segment {
      padding: 1em 0em;
    }
    .masthead .logo.item img {
      margin-right: 1em;
    }
    .masthead .ui.menu .ui.button {
      margin-left: 0.5em;
    }
    .masthead h1.ui.header {
      margin-top: 0.2em;
      margin-bottom: 0em;
      font-size: 2.8em;
      font-weight: normal;
    }
    .masthead h2 {
      font-size: 1.8em;
      font-weight: normal;
    }

    .ui.vertical.stripe {
      padding: 8em 0em;
    }
    .ui.vertical.stripe h3 {
      font-size: 2em;
    }
    .ui.vertical.stripe .button + h3,
    .ui.vertical.stripe p + h3 {
      margin-top: 3em;
    }
    .ui.vertical.stripe .floated.image {
      clear: both;
    }
    .ui.vertical.stripe p {
      font-size: 1.33em;
    }
    .ui.vertical.stripe .horizontal.divider {
      margin: 3em 0em;
    }

    .quote.stripe.segment {
      padding: 0em;
    }
    .quote.stripe.segment .grid .column {
      padding-top: 5em;
      padding-bottom: 5em;
    }

    .footer.segment {
      padding: 5em 0em;
    }

    .secondary.pointing.menu .toc.item {
      display: none;
    }

    @media only screen and (max-width: 700px) {
      .ui.fixed.menu {
        display: none !important;
      }
      .secondary.pointing.menu .item,
      .secondary.pointing.menu .menu {
        display: none;
      }
      .secondary.pointing.menu .toc.item {
        display: block;
      }
      .masthead.segment {
        min-height: 230px;
      }
      .masthead h1.ui.header {
        font-size: 2em;
        margin-top: 0.6em;
      }
      .masthead h2 {
        margin-top: 0.5em;
        font-size: 1.5em;
      }
    }

    .ui.cards {
        max-width: 80%;
        margin-top: 15px;
      }
     .ui.cards .card {
      box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.2);
     } 

  @media only screen and (max-width: 700px) {
      .ui.cards {
        max-width: 100%
      }
    }

  </style>
</head>


<!-- Sidebar Menu -->
<div class="ui header vertical inverted sidebar menu">
  <a class="item {{ request()->is('/') ? 'active' : '' }}" href="{{url('/')}}">Trang chủ</a>
  <a class="item {{ request()->is('giohang') ? 'active' : '' }}" href="{{url('giohang')}}">Giỏ hàng</a>
  <a class="item {{ request()->is('dangnhap') ? 'active' : '' }}" href="{{url('dangnhap')}}">Đăng nhập</a>
  <a class="item {{ request()->is('dangky') ? 'active' : '' }}" href="{{url('dangky')}}">Đăng ký</a>
</div>


<!-- Page Contents -->
<div class="pusher">
  <div style="background: url({{asset('images/banner.jpg')}});background-size: cover;
  background-position: center;" class="ui inverted vertical masthead center aligned segment">

    <div class="ui container">
      <div class="ui header large secondary inverted pointing menu" style="margin-top: -10px">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="item {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
  <a class="item {{ request()->is('giohang') ? 'active' : '' }}" href="{{url('giohang')}}" id="giohang" data-inverted="" data-tooltip="@php $carts=Session::get('cart') @endphp
            @if($carts)
              <table style='width:400px' class='ui celled table' >
  <thead >
    <tr><th class='right marked blue'>Sản phẩm</th>
    <th class='right marked blue'>Số lượng</th>
    <th class='right marked blue'>Giá tiền</th>
  </tr></thead>
  <tbody>
  @foreach($carts as $cart)
    <tr>
      <td style='font-weight:bold;color:#2185d0;'>{{ Str::limit($cart['book_name'],40)}}</td>
      <td style='font-weight:bold;color:#2185d0;'>{{ $cart['book_amount']}}</td>
      <td  style='font-weight:bold;width:100px;color:#2185d0 '>{{number_format($cart['book_price'])}} đ</td>
    </tr>
    @endforeach
  </tbody>
</table>
            @else Chưa có sản phẩm ! @endif">Giỏ hàng <div class="ui red label">
              @if($carts) {{count($carts)}} @else 0 @endif </div>
            </a>       

<div class="ui search item">
  <div class="ui icon input">
    <input class="prompt" type="text" placeholder="Tìm kiếm theo tên sách">
    <i class="search icon"></i>
  </div>
  <div class="results"></div>
</div>

        <div class="right item">
        @php $user = Session::get('user'); @endphp
                       @if($user)
                            

<div class="ui small compact menu" style="transform: translateY(5px)">
  <div class="ui simple inline dropdown item" style="color: black;font-size: 1.8ch;font-weight: bold;">
    <i class="user icon"></i>
      {{ $user->name }}                              
    <i class="dropdown icon"></i>
    <div class="menu" >
       <a class="item"  href="{{url('/donhang')}}">Đơn hàng của bạn</a>
     <a class="item"  href="{{url('dangxuat')}}"> Đăng xuất</a>
    </div>
  </div>
</div>                        

@else
          <a class="ui inverted button" href="{{url('dangnhap')}}">Đăng nhập</a>
          <a class="ui inverted button" href="{{url('dangky')}}">Đăng ký</a>
@endif
        </div>
      </div>
    </div>

    <div class="ui text container">
      <br>
      <h1 class="ui inverted header" style="font-size:35px">
        Cửa hàng kinh doanh sách online
      </h1>
    </div>
<br><br>

  </div>


</html>

