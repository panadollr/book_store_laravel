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
     
    </div>
  </div>
</div>


<script src="{{ asset('assets/jquery.min.js') }}" ></script>
<script src="{{ asset('assets/semantic.min.js') }}"></script>
<script src="{{ asset('assets/vue.js') }}"></script>



<script>
    $(document).ready(function() {
      $('.ui.sidebar')
        .sidebar('attach events', '.toc.item');
    });

    $('#giohang').popup();


function fetchPOST(url ,data_request){
  var payload = {};
  data_request.forEach(d_request => {
    payload[d_request.name] = d_request.data;
  });
 return fetch(url, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
  },
  body: JSON.stringify(payload)
})
.then(response => response.json())
.catch(error => {
  errorAlert(error);
    });
}

function addToCart(url, data_request){
  fetchPOST(url, data_request).then(data => {
    document.querySelector('#giohang .label').textContent = data.cart_size
    successAlert(data.alert)
  })
}

$('.ui.search')
  .search({
    apiSettings: {
      url: "{{ url('timkiem') }}/{query}"
    },
    fields: {
      results : 'books',
      title   : 'book_title',
      url: 'url'
    },
    error: {
      noResults: 'Không tìm thấy kết quả', // Custom message for empty results
    },
  })
;


function successAlert(msg){
  $('body').toast({
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

