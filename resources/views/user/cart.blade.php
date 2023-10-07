  @include('user.layouts.header')

      <h1 class="ui center aligned header">Giỏ hàng</h1>

    <div id="carts" style="padding: 20px">

    <div v-if="!carts || carts.length === 0">
  <h1 style="padding: 150px;" class="ui center aligned header">Không có sản phẩm !</h1>
</div>

<div>
  <div class="ui two column stackable grid">

    <div class="column" style="width:70%;">
<div class="ui relaxed divided list" style="padding: 10px">
        <div v-for="(cart, key) in carts" :key="key" v-if="cart.book_amount > 0" class="item" style="border-radius: 20px;box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);padding: 5px; margin-top: 10px; margin-left: 5px">
            <div class="right floated content" style="margin-top: 30px">
                <button class="ui icon button" @click="subtract(key)"><i class="minus icon"></i></button>
                <div class="ui input" style="width: 60px">
                    <input disabled :id="'cart_quantity' + key" :value="cart.book_amount">
                </div>
                <button @click="plus(key)" style="margin-left: 3px" class="ui icon button"><i class="plus icon"></i></button>
                <a @click="deleteCart(key)" class="ui red button">Xóa</a>  
            </div>
            <img class="ui tiny rounded image" :src="cart.book_image" alt="" srcset="">
            <div class="content">
                <h3 class="header">@{{ cart.book_name.slice(0, 100) }}</h3>
                <div class="description" style="color: #2185d0">
                    <h3>Giá tiền: @{{ formatPrice(cart.book_price) }} đ</h3>
                </div>
                <h3>Thành tiền : @{{ formatPrice(cart.book_price * cart.book_amount) }} đ</h3>
            </div>
        </div>
    </div>
    </div>

    <div class="middle aligned column" style="width: 30%" v-if="carts.length != 0">
 <center>  
 <h1 class="ui blue header" id="all_total">Tổng tiền: @{{ formatPrice(total) }}</h1>
  <div class="ui large buttons">
  <a href="{{ url('/khosach') }}"><button class="ui button" style="background:#DCDCDC;" id="demo" >Tiếp tục mua sắm</button></a>
  <div class="or" data-text=""></div>
  <a href="{{URL::to('/checkout')}}"><button class="ui blue button">Tiến hành thanh toán</button></a>
</div>
</center>
    </div>
  </div>
 
</div>
</div>

<div style="height: 300px"></div>
 @include('user.layouts.footer')

 <script>
  
  new Vue({
    el: '#carts',
    data: {
        carts: [],

    },
    created() {
    if (@json($carts)) {
      this.carts = @json($carts);
    }
  },
    computed: {
    total() {
      let totalPrice = 0;
      for (const key in this.carts) {
        if (this.carts[key].book_amount > 0) {
          totalPrice += this.carts[key].book_price * this.carts[key].book_amount;
        }
      }
      return totalPrice;
    },
  },
    methods: {
      updateCartQuantity(key, quantity){
  var url = "{{ url('update_cart_quantity') }}";
  var data_requests = [ {name: "key", data: key}, 
  {name: "quantity", data: quantity}];
  fetchPOST(url, data_requests).then(data => {
    successAlert(data.alert)
    document.querySelector('#giohang .label').textContent = data.cart_size;
    this.carts = data.carts
  })
},
        subtract(key) {
                this.updateCartQuantity(key, this.carts[key].book_amount -=1);
        },
        plus(key) {
          this.updateCartQuantity(key, this.carts[key].book_amount +=1);
        },
        deleteCart(key) {
          this.updateCartQuantity(key, 0);
        },
        deleteAll(){
          var url = "{{ url('delete_all_carts') }}";
          fetchPOST(url, []).then(data => {
    successAlert(data.alert)
    document.querySelector('#giohang .label').textContent = data.cart_size;
    this.carts = data.carts
  })
        },
        formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        },
    },
});

 </script>