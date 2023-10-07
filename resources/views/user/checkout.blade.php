  @include('user.layouts.header')
  
 @php 
 $order_total=0; 
 @endphp

<h1 class="ui center aligned header" >Thông tin thanh toán</h1>

<br>
<div class="ui center aligned container" style="width:90%;text-align: left">

<div class="ui segment" style=" border-radius: 25px;padding: 40px">
  <div class="ui two column very relaxed stackable grid">
    <div class="column">
      <h3>Xem lại giỏ hàng</h3>
    <table class="ui blue large celled table">
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
      <td><img style="width:70px" class="ui rounded image"  src="{{$cart['book_image']}}" alt=""></td>
      <td>{{$cart['book_amount']}}</td>
      <td>{{number_format($cart['book_price'])}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
    </div>
    <div class="column">
    <h3>Điền thông tin</h3>
    <form class="ui form" style="width:100%" method="POST" action="{{url('tienhanhthanhtoan')}}">
      @csrf
  <div class="field">
    <label>Tên người nhận</label>
    <input type="text" name="shipping_name" placeholder="" required>
  </div>
  
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
<input type="hidden" name="order_total" value="{{ $order_total}}">
<center><button class="ui large right labeled icon blue button" type="submit">
  <i class="right arrow icon"></i>
   Hoàn tất thanh toán</button></center>
</form>
    </div>
  </div>

</div>

</div>


<div style="height:150px"></div>
 @include('user.layouts.footer')
