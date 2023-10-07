@include('user.layouts.header')

<br>
<div class="ui container">
    <h2 class="ui center aligned header">Đơn hàng của bạn</h2>

    <div id="order_status_menu" class="ui large three item menu">
    <a href="{{ url('donhang') }}" class="red item {{ request()->query('status') === null ? 'active' : '' }}">Đang chờ xác nhận</a>
<a href="{{ url('donhang?status=danggiaohang') }}" class="blue item {{ request()->query('status') === 'danggiaohang' ? 'active' : '' }}">Đang giao hàng</a>
<a href="{{ url('donhang?status=dagiaohang') }}" class="green item {{ request()->query('status') === 'dagiaohang' ? 'active' : '' }}">Đã giao hàng</a>
</div>


@if(count($user_orders) > 0)
<div class="ui list">
@foreach($user_orders as $order)
  <div class="ui item segment" style="background:white;padding: 10px; margin-top:20px;border-radius:20px;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);">
    <div class="content">

    <div class="ui large relaxed divided list">
    @foreach($order_details as $order_detail)
        @if($order->order_id == $order_detail->order_id)
  <div class="item">
  <img class="ui middle aligned tiny image" src="{{$order_detail->book_image}}">
    <div class="content">
      <div class="header">{{$order_detail->product_name}}</div>
      <h4>{{number_format($order_detail->product_price)}} đ</h4>
      <div class="description">Số lượng : {{$order_detail->product_sales_quantity}}</div>
    </div>
  </div>
  @endif
  @endforeach
</div>


<div class="right floated container">
<h3>Tổng tiền : {{number_format($order->order_total)}} đ</h3>
@if($order->order_status == 'Đang chờ xác nhận')
<a href="{{url('/xoadonhang/'.$order->payment_id)}}" class="ui red button">
          Hủy đơn hàng
          <i class="right trash icon"></i>
        </a>
        @endif
        </div>

    </div>
  </div>
@endforeach
@else
<h2 style="padding:60px" class="ui center aligned header">Chưa có đơn hàng nào !</h2>
@endif
</div>

</div>

<div style="height:150px"></div>
@include('user.layouts.footer')
