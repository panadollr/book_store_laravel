@include('user.layouts.header')

<style>
  .ui.book.details.segment {
            padding: 25px;
            border-radius: 30px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }
</style>

@php
$userSession = Session::get('user');
@endphp

<div class="ui container" style="margin-top:30px;">

  <div class="ui two column stackable grid">
    <div class="column" style="width: 60%">
     
    <div class="ui book details segment" id="book_details-segment">
        <h2 class="ui header">{{ $bookdetail->book_title}}</h2>
        <div class="ui items">
  <div class="item">
    <div class="ui image">
      <img style="height:300px" src="{{asset($bookdetail->book_image)}}">
    </div>
    <div class="content">
    <div class="ui large black label"> ISBN {{$bookdetail->book_isbn}}</div>
    <div class="ui large label"> {{$bookdetail->book_author}}</div>
    <div class="meta">
        <span class="cinema">{{ $bookdetail->book_descr}}</span>
      </div>
      <a class="header">{{ number_format($bookdetail->book_price)}} đ</a>
      <div class="description">
        <p></p> 
      </div>
      <div class="extra">
      <div class="ui right floated ">
          <form id="addToCartForm">
            @csrf
           <div class="ui labeled input"><div class="ui label" >
   Số lượng
  </div> <input type="number" name="quantity" value="1" min="1" max="20"></div>
           <button name="cart" class="ui blue button" type="submit">Thêm vào giỏ hàng <i class="right cart icon"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      </div>

      <div class="ui book details segment" style="margin-top:25px;">
        <h3 class="ui header">Các sản phẩm khác</h3>
        <div class="ui blue three link doubling cards" style="max-width: 100%">
        @foreach($other_books as $book)
          <a href="{{ url('chitietsach/'.$book->id)}}" class="card">
          <div class="image">
      <img style="height:300px;object-fit:cover" src="{{asset($book->book_image)}}">
    </div>
          </a>
          @endforeach
        </div>
    </div>


    </div>
    <div class="column" style="width: 40%">
     
    <div class="ui book details segment" id="comments-vue">

<div class="ui center aligned container" v-if="userSession">
<h3>Bạn đánh giá sản phẩm này bao nhiêu sao ?</h3>
<div style="padding: 10px;" class="ui massive yellow rating" id="rating"></div>
<span id="rate_text" style="font-weight: bold;font-size: 18px;"></span>
<input type="hidden" name="rating" value="0" ref="ratingInput">
<div style="width: 100%;" class="ui input">
<textarea style="width: 100%;
            resize: none;" v-model="newCommentText" @keyup.enter="postComment"></textarea>
      </div>
      <br><br>
<button class="ui fluid black button" @click="postComment">Đánh giá</button>
</div>

<div v-else>
  <h3 class="ui blue center aligned header">Vui lòng đăng nhập để tiếp tục đánh giá sản phẩm</h3>
</div>

  <div class="ui comments" style="max-height: 500px; overflow-y:scroll">
  
    <div v-for="comment in comments" :key="comment.comment_id" class="comment">
      <a class="avatar">
      <i class="user big outline icon"></i>
      </a>
      <div class="content">
    
<a class="author">@{{ comment.name }}</a>

        <div class="metadata">
          <span class="date">@{{ comment.comment_date }}</span>
 <i v-for="n in parseInt(comment.comment_rating)" :key="n" class="yellow star icon"></i>
        </div>
        <div class="text">
        @{{comment.comment_content}}
        </div>
      </div>
    </div>
    
  </div>

  <h3 class="ui center aligned header" v-if="comments.length == 0" id="no_comments_text">Chưa có bình luận nào...</h3>
</div>

  </div>

        

      </div>

      

</div>

 @include('user.layouts.footer')

 <script>
 document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const quantity = document.querySelector('#addToCartForm input[name="quantity"]').value;
    var data = [ {name: "book_id", data: '{{ $bookdetail->id }}'},
  {name: "quantity", data: quantity} ]
    addToCart('{{URL::to('add_to_cart')}}', data);
    
    $('#book_details-segment').css({'transition':'0.5s'})
    .css({'transform':' translateY(-100%) scale(0.05)'})
    .css({'opacity':'0'})

setTimeout(()=>{
  $('#book_details-segment').css({'transition':'0s'}).css({'transform':' translateY(50%) translateX(0)'})
},400)

setTimeout(()=>{
  $('#book_details-segment').css({'transition':'0.5s'}).css({'transform':' translateY(0) translateX(0)'})
  .css({'opacity':'1'})
},600)
  });

new Vue({
  el: '#comments-vue',
  data: {
    comments: @json($comments),
    users: @json($users),
    newCommentText: '',
    userSession: @json($userSession)
  },
  methods: {
    postComment(){

      const ratingInputValue = this.$refs.ratingInput.value;
      if (this.newCommentText.trim() !== '' && ratingInputValue != 0) {
        const newComment = {
          comment_content: this.newCommentText,
          comment_rating: ratingInputValue,
        };
        var url = "{{URL::to('dangbinhluan')}}";
        const data = [ {name: 'book_id', data: '{{ $bookdetail->id }}'},
        {name: 'comment_content', data: newComment.comment_content},
        {name: 'comment_rating', data: newComment.comment_rating},
        {name: 'user_id', data: this.userSession.id}]
        fetchPOST(url, data).then(data => {
          successAlert(data.alert)
          newComment.name = this.userSession.name
          newComment.comment_date = data.newComment.comment_date
          this.comments.unshift(newComment);
        this.newCommentText = ''; 
        $('.ui.rating')
  .rating('clear rating', true);
        })
      } else {
        errorAlert("Bình luận và số sao không được để trống")
      }

    }
  }
})

$('.rating').rating({
    initialRating: 0,
    maxRating: 5
  });

  const rateTextArr = ['Rất tệ', 'Tệ', 'Ổn', 'Tốt', 'Rất tốt'];
  for (let i = 1; i <= $('.rating').children().length; i++) {
    $('.rating i:nth-child(' + i + ')').click(function() {
      $("#comments-vue input[name*='rating']").val(i);
      $('#rate_text').text(rateTextArr[i - 1]);
    });
  }



</script>







