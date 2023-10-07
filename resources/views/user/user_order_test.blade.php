@include('user.layouts.header')

<br>
<div id="index-app" class="ui container">
    <h2 class="ui center aligned header">Đơn hàng của bạn</h2>

    <div id="order_status_menu" class="ui large three item menu">
    <a @click="loadOrdersByStatus('dang_cho_xac_nhan')" :class="{ active: activeItem === 'dang_cho_xac_nhan' }" class="red item">Đang chờ xác nhận</a>
<a @click="loadOrdersByStatus('dang_giao_hang')" :class="{ active: activeItem === 'dang_giao_hang' }" class="blue item">Đang giao hàng</a>
<a @click="loadOrdersByStatus('da_giao_hang')" :class="{ active: activeItem === 'da_giao_hang' }" class="green item">Đã giao hàng</a>
</div>


<div class="ui list" v-if="user_orders">

<div v-for="user_order in user_orders" class="ui item segment" style="background:white;padding: 10px; margin-top:20px;border-radius:20px;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);">
    <div class="content">
    <div class="ui large relaxed divided list">
  <div class="item" v-for="order_detail in order_details" v-if="order_detail.order_id === user_order.order_id">
  <img class="ui middle aligned tiny image" :src="order_detail.book_image">
    <div class="content">
      <div class="header">@{{ order_detail.product_name }}</div>
      <h4> @{{ formatPrice(order_detail.product_price) }} đ</h4>
      <div class="description">Số lượng : @{{ order_detail.product_sales_quantity }}</div>
    </div>
  </div>
</div>

<div class="right floated container">
<h3>Tổng tiền : @{{ formatPrice(user_order.order_total) }} đ</h3>

<a v-if="user_order.order_status == 'Đang chờ xác nhận'" @click="deleteUserOrder(user_order.order_id)" class="ui red button">
          Hủy đơn hàng
          <i class="right trash icon"></i>
        </a>
        </div>

    </div>
  </div>

<h2 v-if="user_orders.length == 0" style="padding:60px" class="ui center aligned header">Chưa có đơn hàng nào !</h2>
</div>

</div>

<div style="height:150px"></div>
@include('user.layouts.footer')

<script>
  
  new Vue({
            el: '#index-app',
            data: {
                isLoading: false,
                user_orders: [],
                order_details: [],
                activeItem: '',
            },
            methods: {
                loadOrdersByStatus(status) {
                    this.isLoading = true;
                    this.activeItem = status;

                   let url = "{{ url('get_user_orders_by_status=')}}" + status;
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.user_orders = data.user_orders;
                        this.order_details = data.order_details
                    })
                    .catch(error => {
                        this.isLoading = false; 
                        errorAlert("Lỗi, không thể tải dữ liệu !");
                    });
                },

                deleteUserOrder(order_id){
      var url = '{{URL::to('xoadonhang')}}/' + order_id;
      fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(data => {
                      console.log(data)
                    })
                    .catch(error => {
                        this.isLoading = false; 
                        errorAlert("Lỗi, không thể tải dữ liệu !");
                    });
                },
                
                formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        },
            },
            mounted() {
                this.loadOrdersByStatus('dang_cho_xac_nhan');
            },
        });

</script>
