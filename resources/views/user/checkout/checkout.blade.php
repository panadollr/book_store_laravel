  @include('user.layouts.header')
  
 @php 
 $order_total=0; 
 @endphp

<br>
<h1 class="ui center aligned header" style="margin-top:50px">Thông tin thanh toán</h1>

<div class="ui center aligned container" style="width:80%;text-align: left">

    <form class="ui form" method="POST" action="{{url('tienhanhthanhtoan')}}">
      @csrf
  <div class="field">
    <label>Tên người nhận</label>
    <input type="text" name="shipping_name" placeholder="" required>
  </div>
  <div class="two fields">
  <div class="field">
  <label>Tỉnh / Thành phố</label>
  <select name="shipping_city">
  <option value="Hà Nội">Hà Nội</option>
  <option value="Đà Nẵng">Đà Nẵng</option>
  <option value="Hồ Chí Minh">Hồ Chí Minh</option>
</select>
  </div>
  <div class="field">
  <label>Địa chỉ cụ thể</label>
    <input required type="text" name="shipping_address" placeholder="VD: Số nhà/ Thôn ..., Xã ..., Huyện ...">
  </div>
  </div>

<hr>

<h3 class="ui center aligned header">Xem lại giỏ hàng<i class="cart arrow down icon" style="margin-left: 20px;"></i><?php echo count($carts)?></h3>
    <table class="ui blue celled table">
  <thead>
    <tr><th>Sản phẩm</th>
    <th>Hình ảnh</th>
    <th>Số lượng</th>
    <th>Giá tiền</th>
  </tr></thead>
  <tbody>
    @foreach($carts as $cart)
    @php $order_total+=$cart['book_amount']*$cart['book_price'] @endphp
    <tr>
      <td>{{$cart['book_name']}}</td>
      <td><img style="width:100px" class="ui rounded image"  src="{{$cart['book_image']}}" alt=""></td>
      <td>{{$cart['book_amount']}}</td>
      <td>{{number_format($cart['book_price'])}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<input type="hidden" name="order_total" value="{{ $order_total}}">
<br>
  <center><button class="ui large right labeled icon blue button" type="submit">
  <i class="right arrow icon"></i>
    Thanh toán</button></center>
</form>

</div>


<br>
 @include('user.layouts.footer')
