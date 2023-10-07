@include('user.layouts.header')

<style>
  #loading {
    height: 300px;
    margin-top:120px
  }
  .cards {
    display: none;
  }
  </style>

  <br>

  <!-- index-app -->
<div id="index-app">
<div id="books_type_menu" class="ui center aligned blue labeled big icon compact menu">
            <!-- Menu items with click handlers -->
            <a class="item" v-for="menuItem in menuItems"
               :key="menuItem.type"
               @click="loadBooksByType(menuItem.type)"
               :class="{ 'item': true, 'active': menuItem.active }"
               :data-book_type="menuItem.type">
               <span v-html="menuItem.icon"></span>@{{menuItem.label}}
            </a>
        </div>
<center>
        <div v-if="isLoading">
            <!-- Loading indicator -->
            <div id="loading" class="ui active massive blue inline loader"></div>
            </div>
            
            <!-- Book cards -->
            
            <div v-else class="ui center aligned six doubling special cards" style="margin-top:40px">
                <div class="card" v-for="book in books" :id="'card' + book.id">

                    <div class="ui move up instant reveal image">
       <img :src="book.book_image" class="visible content" style="object-fit: cover;height: 350px;">
         <div class="hidden center aligned content" style="background:white;height:100%;padding:5px;scroll: visible">
         <br> 
         <h3 class="ui black header">@{{book.book_title}}</h3>
          <div>
            
    <div v-if="getRatings(book.id)">
        <i class="large star yellow icon" v-for="n in getRatings(book.id)" :key="n"></i>
    </div>

    <br>
    <div v-if="book.quantity" class="ui green label">
           Đã bán <div class="detail">@{{book.quantity}}</div>
 </div>
 <h3 class="ui blue header"> @{{(book.book_price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}} </h3>
          <a :href="'{{ url('chitietsach')}}/' + book.id" 
          class="ui right labeled icon fluid blue button">
          <i class="right arrow icon"></i>
          Xem</a><hr>
          <button @click="addToCartInBooksIndex(book.id)" class="ui icon fluid black button">
          <i class="cart plus icon"></i>
          </button>
</div>
</div>
</div>
                    
            </div>
        </div>
</center>
</div>
 <!-- end-index-app -->

<div style="height:100px"></div>
@include('user.layouts.footer')


<script>
   $('.ui.rating').rating('disable');

new Vue({
            el: '#index-app',
            data: {
                isLoading: false,
                menuItems: [
                    { type: 'moi_nhat', icon: '<i class="certificate icon"></i>', label: 'Mới Nhất', active: false },
                    { type: 'ban_chay', icon: '<i class="chart line icon"></i>', label: 'Bán chạy', active: false },
                    { type: 'gia_thap', icon: '<i class="arrow down icon"></i>', label: 'Giá thấp', active: false },
                    { type: 'gia_cao', icon: '<i class="arrow up icon"></i>', label: 'Giá cao', active: false },
                ],
                books: [],
                ratings: [],
            },
            methods: {
                loadBooksByType(type) {
                    this.isLoading = true;
                    this.menuItems.forEach(item => item.active = false);
                    const clickedItem = this.menuItems.find(item => item.type === type);
                    if (clickedItem) {
                        clickedItem.active = true;
                    }
                    var protocol = window.location.protocol;
                    let url;
    if (protocol === 'https:') {
                    url = "{{ secure_url('/load_books_by_type')}}/" + type;
    } else {
                    url = "{{ url('/load_books_by_type')}}/" + type;
    }
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.books = data.books.data;
                        this.ratings = data.ratings;
                        this.isLoading = false; 
                    })
                    .catch(error => {
                        this.isLoading = false; 
                        errorAlert("Lỗi, không thể tải dữ liệu !");
                    });
                },
                getRatings(book_id){
                const rating = this.ratings.find(rating => rating.book_id === book_id);
                return rating ? parseInt(rating.rating) : null;
                },
                addToCartInBooksIndex(book_id){
      var url = '{{URL::to('add_to_cart')}}';
  var data = [ {name: "book_id", data: book_id},
  {name: "quantity", data: 1} ]
  addToCart(url, data)
  
                }
            },
            mounted() {
                this.loadBooksByType('moi_nhat');
            },
        });

</script>


