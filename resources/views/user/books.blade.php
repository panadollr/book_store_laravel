@include('user.layouts.header')

<style>
  #loading {
    height: 200px;
    margin-top:120px
  }
  .cards {
    display: none;
  }
  </style>

<h1 class="ui center aligned header">Kho sách</h1>

    <div id="books_type_menu" class="ui center aligned blue labeled icon compact menu">
    <a class="active item" data-book_type="moi_nhat" onclick="loadBooksByType('moi_nhat')"><i class="certificate icon"></i>Mới nhất</a>
    <a class="item" data-book_type="ban_chay" onclick="loadBooksByType('ban_chay')"><i class="chart line icon"></i>Bán chạy</a>
  <a class="item" data-book_type="gia_thap" onclick="loadBooksByType('gia_thap')"><i class="arrow down icon"></i>Giá thấp</a>
  <a class="item" data-book_type="gia_cao" onclick="loadBooksByType('gia_cao')"><i class="arrow up icon"></i>Giá cao</a>
</div>

<center>
<div id="book_cards" class="ui five doubling special cards">
<div id="loading" class="ui active massive blue centered inline loader"></div>
</div>
</center>


@include('user.layouts.footer')

<script>

setTimeout(() => {
   loadBooksByType('moi_nhat');
},500);
 
 
    function loadBooksByType(type){
        let bookCards = document.getElementById('book_cards');
        const loadingSegment = `<div id="loading" class="ui active massive blue centered inline loader"></div>`;
bookCards.innerHTML = loadingSegment;

const menuItems = document.querySelectorAll('#books_type_menu a.item');
  menuItems.forEach(item => item.classList.remove('active'));
  // Set the "active" class on the clicked menu item
  const clickedItem = document.querySelector(`#books_type_menu a[data-book_type="${type}"]`);
  clickedItem.classList.add('active');
        const url = "{{URL::to('/load_books_by_type')}}/"+ type
        fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
    })
    .then(response => response.json())
    .then(data => {
      const books = data.books.data
      const ratings = data.ratings
      loading = false;
      let html = ``
      books.forEach(book => {
       html += ` <div id="card${book.id}" class="card">
      <div class="ui move up instant reveal image">
      <img src="${book.book_image}" class="visible content" style="object-fit: cover;height: 350px;">
        <div class="hidden center aligned content" style="background:white;height:100%;padding:10px">
        <br> 
        <h3 class="ui black header">${book.book_title}</h3>`
         ratings.forEach(rating => {
            if(rating.book_id == book.id){
      html += `<div class="ui star yellow rating" data-rating="${rating.rating}" data-max-rating="5"></div>`
             } else {
   html += `<div class="ui star yellow rating" data-rating="0" data-max-rating="5"></div>`
            }
         })
 
         html += `<h3 class="ui blue header"> ${(book.book_price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })} </h3>
         <button onclick="window.location.href='{{ url('chitietsach/')}}/${book.id}'" 
         class="ui right labeled icon fluid blue button">
         <i class="right arrow icon"></i>
         Xem</button><hr>
         <button onclick="addToCartInBooksIndex('${book.id}')" class="ui icon fluid black button">
         <i class="cart plus icon"></i>
         </button>
        
         </div>
</div>
  </div>`
      })
bookCards.innerHTML = html;
  $('.ui.rating').rating('disable');
    })
    .catch(error => {
      errorAlert("Lỗi, không thể tải dữ liệu !");
    });
    }

    function addToCartInBooksIndex(book_id) {
      $('#card'+book_id).transition('fade down')
    addToCart(book_id, 1);
    $('#card'+book_id).transition('fly up')
  };
</script>