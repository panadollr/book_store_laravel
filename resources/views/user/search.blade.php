@include('user.layouts.header')

<style>
  #searched2_books .searched_book.item {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
  padding:10px;border-radius: 20px;
  transition: 0.2s;
  visibility: hidden;
  border : 3px solid #2185d0
  }
  #searched2_books .searched_book.item:hover {
    box-shadow: none;
   transform: scale(0.99)
  }
</style>


<br>

<div class="ui center aligned container">

    <h1 class="ui header">Tìm kiếm</h1>
  <div class="ui massive search">
  <div class="ui icon input">
  @csrf 
    <input style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);" id="search2_input" class="prompt" type="text" placeholder="Gõ tên sách...">
    <i class="search icon"></i>
  </div>
</div>


<div id="searched2_books" class="ui items" style="padding: 20px;">
</div>


</div>

<script>
    document.getElementById('search2_input').addEventListener('keyup', function() {
  var query = this.value; // Get the user input value
  let $countryList = document.getElementById('searched2_books');
  if (query !== '') {
    var _token = document.querySelector('input[name="_token"]').value; // Get the token value
    fetch("{{route('timkiemsach')}}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": _token
      },
      body: JSON.stringify({ query })
    })
      .then(response => response.json())
      .then(data => {
        let html = ``
        data.forEach(book => {
        html += ` <div class="searched_book item">
    <div class="image">
      <img style="width:130px" src="${book.book_image}">
    </div>
    <div class="content" style="padding: 20px">
      <h1 class="header">${book.book_title}</h1>
      <div class="meta">
        <h3>${(book.book_price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</h3>
      </div>
      <div class="extra">
      ${(book.book_author)}
      </div>
      <a href="{{url('chitietsach/${book.id}')}}" class="ui blue button">Xem chi tiết</a>
    </div>
  </div>`
        });
        html += ``;
        $countryList.innerHTML = html;
        $('#searched2_books .searched_book.item').transition('fade')
      });
  } else {
    $countryList.innerHTML = ``
  }
});

</script>

<br><br><br><br><br><br><br><br><br>
@include('user.layouts.footer')

