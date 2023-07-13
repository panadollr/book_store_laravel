<br>
  <div class="ui inverted vertical footer segment" id="footer" >
  <div class="ui container">
    <div class="ui stackable inverted divided equal height stackable grid">
      <div class="three wide column">
        <h4 class="ui inverted header">Thông tin</h4>
        <div class="ui inverted link list">
          <a href="#" class="item">Chính sách bảo mật</a>
          <a href="#" class="item">Điều khoản</a>
          <a href="#" class="item">Liên hệ với</a>
        </div>
      </div>
      <div class="three wide column">
        <h4 class="ui inverted header">Chăm sóc khách hàng</h4>
        <div class="ui inverted link list">
          <a href="" class="item">Trung tâm trợ giúp</a>
          <a href="#" class="item">DNA FAQ</a>
          <a href="#" class="item">Hướng dẫn mua hàng</a>
        </div>
      </div>
      <div class="seven wide column">
        <h4 class="ui inverted header">Thanh toán</h4>
        <img src="https://cdn.vhost.vn/wp-content/uploads/2017/05/ho-tro-thanh-toan-qua-the-ngan-hang-vhost.jpg" class="ui image">
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('assets/jquery.min.js') }}" ></script>
<script src="{{ asset('assets/semantic.min.js') }}"></script>

<script>
    var currentUrl = "{{request()->url()}}";
$('.header.menu .item').each(function() {
  var href = $(this).attr('href');
  
  if (currentUrl === href) {
    $(this).addClass('active');
  }
});
    
 $(document)
    .ready(function() {

      $('.ui.sidebar')
        .sidebar('attach events', '.toc.item');

    });

    $('#giohang').popup();

function addToCart(book_id, quantity){
  fetch('{{URL::to('/save_cart/')}}/' + book_id, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        quantity: quantity,
      })
    })
    .then(response => response.json())
    .then(data => {
      let html = `<table style='width:400px' class='ui celled table' >
  <thead >
    <tr><th class='right marked blue'>Sản phẩm</th>
    <th class='right marked blue'>Số lượng</th>
    <th class='right marked blue'>Giá tiền</th>
  </tr></thead>
  <tbody>`
  let cart_length = 0;
  for (let key in data) {
  if (data.hasOwnProperty(key)) {
    cart_length += 1;
    const formattedPrice = Number(data[key].book_price).toLocaleString('vi-VN', {
  style: 'currency',
  currency: 'VND'
});
    html += `<tr>
      <td style='font-weight:bold;color:#2185d0;'>${data[key].book_name}</td>
      <td style='font-weight:bold;color:#2185d0;'>${data[key].book_amount}</td>
      <td  style='font-weight:bold;width:100px;color:#2185d0 '>${formattedPrice}</td>
    </tr>`
  }
}
  html += `</tbody>
</table>`

  document.querySelector('#giohang .label').textContent =  cart_length;

document.querySelector('#giohang').setAttribute('data-html', html);
successAlert("Đã thêm vào giỏ hàng !");
    })
}


function successAlert(msg){
  $('body')
  .toast({
     class: 'success',
    message: msg,
  });
}

function errorAlert(msg){
  $('body')
  .toast({
     class: 'error',
    message: msg,
  });
}

</script>

