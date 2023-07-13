  @include('user.layouts.header')

  @php 
  $carts = Session::get('cart');
  $total=0; 
  @endphp

      <h1 class="ui center aligned header">Giỏ hàng</h1>

    @if($carts)
    <div id="all">
  <div class="ui two column stackable grid">
    <div class="column" style="width:70%;">
    
    <!-- <table class="ui large table">
  <thead>
    <tr><th>Sản phẩm</th>
    <th>Hình ảnh</th>
    <th>Số lượng</th>
    <th>Giá tiền</th>
    <th>Thành tiền</th>
    <th colspan="2">Tùy chỉnh</th>
  </tr></thead>
  <tbody>
    @foreach($carts as $key => $cart)
    @php $total+=$cart['book_price']*$cart['book_amount'] @endphp
    <tr id="cart{{$key}}">
      <td>{{Str::limit($cart['book_name'],100)}}</td>
      <td><img style="width:100px" class="ui rounded image" src="{{$cart['book_image']}}" alt="" srcset=""></td>
      <td>{{number_format($cart['book_price'])}} đ</td>

      <td>
  <div class="ui labeled input">
  <button class="ui icon button" onclick="subtract('{{$key}}')"><i class="minus icon"></i></button>
  <div class="ui input" style="width:60px">
  <input disabled id="cart_quantity{{$key}}" value="{{$cart['book_amount']}}">
</div>
  <button onclick="plus('{{$key}}')" style="margin-left: 3px" class="ui icon button"><i class="plus icon"></i></button>
  </div>
</td>

      <td id="total">{{number_format($cart['book_price'] * $cart['book_amount'])}} đ</td>
      <td><a onclick="deleteCart('{{$key}}')" class="ui red button">Xóa</a></td>
</form>
    </tr>
    @endforeach
  </tbody>
</table> -->

<div class="ui relaxed divided list">
@foreach($carts as $key => $cart)
  <div id="cart{{$key}}" class="item" style="box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);padding: 5px;
  margin-top: 10px; margin-left: 5px">

  <div class="right floated content" style="margin-top: 30px">
      <button class="ui icon button" onclick="subtract('{{$key}}')"><i class="minus icon"></i></button>
  <div class="ui input" style="width:60px">
  <input disabled id="cart_quantity{{$key}}" value="{{$cart['book_amount']}}">
</div>
  <button onclick="plus('{{$key}}')" style="margin-left: 3px" class="ui icon button"><i class="plus icon"></i></button>
  <a onclick="deleteCart('{{$key}}')" class="ui red button">Xóa</a>  
    </div>

  <img class="ui tiny rounded image" src="{{$cart['book_image']}}" alt="" srcset="">
    <div class="content">
      <h3 class="header">{{Str::limit($cart['book_name'],100)}}</h3>
      <div class="description" style="color: #2185d0">
        <h3>Giá tiền: {{number_format($cart['book_price'])}} đ</h3>
    </div>
    <h3>Thành tiền : {{number_format($cart['book_price'] * $cart['book_amount'])}} đ</h3>
    </div>
  </div>
  @endforeach
</div>

    </div>
    <div class="middle aligned column" style="width: 30%">
    
 <center>  
 <h1 class="ui blue header" id="all_total">Tổng tiền: {{number_format((float)$total,0,',','.')}}</h1>

  <div class="ui large buttons">
  <a href="{{ url('/khosach') }}"><button class="ui button" style="background:#DCDCDC;" id="demo" >Tiếp tục mua sắm</button></a>
  <div class="or" data-text=""></div>
  <a href="{{URL::to('/checkout')}}"><button class="ui blue button">Tiến hành thanh toán</button></a>
</div>
</center>

    </div>
  </div>
</div>
@else
<h1 style="padding:105px;" class="ui center aligned header">Không có sản phẩm !</h1>
    @endif


    
<script type="text/javascript">
function xoa(){
  $('#xoa')
  .modal('setting', 'closable', false)
  .modal('show');
}

function plus(key){
  const cartQuantityInput = document.getElementById('cart_quantity' + key);
let quantity = parseInt(cartQuantityInput.value) + 1;
cartQuantityInput.value = quantity
updateCartQuantity(key,quantity)
}

function subtract(key){
  const cartQuantityInput = document.getElementById('cart_quantity' + key);
let quantity = parseInt(cartQuantityInput.value) - 1;
cartQuantityInput.value = quantity;
updateCartQuantity(key,quantity)
}

function deleteCart(key){
  updateCartQuantity(key,0)
}

function updateCartQuantity(key, quantity){
  $('#all_total').transition('bounce')
  const null_cart_h1 = `<h1 style="padding:105px;" class="ui center aligned header">Không có sản phẩm !</h1>`
  const url = "{{URL::to('/update_cart_quantity')}}/" + key + '/'+ quantity;
    fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      if(data.cart){
         const formattedPrice = Number(data.cart.book_price * data.cart.book_amount).toLocaleString('vi-VN', {
  style: 'currency',
  currency: 'VND'
});
        $('#cart' + key + ' #total').text(formattedPrice) 
      }else {
        $('#cart' + key).fadeOut()
      } 

if(data.all_carts.length == 0){
 document.getElementById('all').innerHTML = null_cart_h1
}
        let all_total = 0;
        let all_carts = Object(data.all_carts);
        for (let key in all_carts) {
  if (all_carts.hasOwnProperty(key)) {
    all_total += all_carts[key].book_price * all_carts[key].book_amount;
  }
}
        const formattedTotal = Number(all_total).toLocaleString('vi-VN', {
  style: 'currency',
  currency: 'VND'
});
$('#all_total').text('Tổng tiền: ' + formattedTotal) 
        successAlert(data.alert)
    })
    .catch(error => {
      errorAlert(error);
    });
}


</script>

<br><br><br>
 @include('user.layouts.footer')