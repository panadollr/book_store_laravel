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

<div class="ui container" style="margin-top:30px;width: 93%">

  <div class="ui two column stackable grid">
    <div class="column" style="width: 65%">
     
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

      <div class="ui book details segment" style="margin-top:25px">
        <h3 class="ui header">Các sản phẩm khác</h3>
        <div class="ui blue four link stackable cards">
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
    <div class="column" style="width: 35%">
     
    <div class="ui book details segment" id="comments-segment">
        <h3 class="ui header">Đánh giá sản phẩm</h3>
        <div id="comments" class="ui comments"  style="max-height: 500px; overflow-y:scroll">
        @if(count($comments) > 0)
        @foreach($comments as $comment)
          <div class="comment">
            <a class="avatar">
            <i class="user big outline icon"></i>
            </a>
            <div class="content">
            @foreach($users as $user)
      @if($user->id == $comment->user_id)
      <a class="author">{{$user->name}}</a>
      @endif
      @endforeach
              <div class="metadata">
                <span class="date">{{$comment->comment_date}}</span>
                @php 
      $tr=$comment->comment_rating;
      @endphp
     @for($count=0;$count<$tr;$count++)
       <i class="yellow star icon"></i>
@endfor
              </div>
              <div class="text">
              {{$comment->comment_content}}
              </div>
              @foreach($reply_comment as $key =>$com_reply)
    @if($com_reply->comment_id == $comment->comment_id)
     <div class="reply-comments comments">
        <div class="comment">
          <a class="avatar">
          <i class="user big outline icon"></i>
          </a>
          <div class="content">
          @foreach($users as $user)
      @if($user->id == $com_reply->reply_user_id)
      <a class="author">{{$user->name}}</a>
      @endif
      @endforeach
            <div class="metadata">
      <span class="date">{{$com_reply->reply_date}}</span>
      </div>
            <div class="text">
              {{$com_reply->reply_comment_content}}
            </div>
          </div>
        </div>
      </div>
      @endif
      @endforeach
            </div>
          </div>
          @endforeach
          @else
        <h3 id="no_comments_text">Chưa có bình luận nào...</h3>
        @endif
        </div>

        @if($userSession)
        <form id="commentForm" class="ui form">
  @csrf
  <div class="field" id="comm">
    <h4>Bạn đánh giá sản phẩm này bao nhiêu sao ?</h4>
    <div style="background:white; padding: 7px;border-radius:20px" class="ui massive yellow rating"></div>
    <span id="rate_text" style="font-weight: bold;font-size: 18px;"></span>
    <input type="hidden" name="rating" value="1">
    <input type="hidden" name="user_name" value="{{$userSession->name}}">
    <br><br>
    <textarea style="width: 100%;
            height: 0;
            resize: none;" name="comment_content" style="margin-top: 5px;" class="comment_content" required></textarea>
  </div>
  <center>
    <button type="submit" class="ui blue right labeled submit icon button send-comment">
      <i class="icon edit"></i> Bình luận
    </button>
  </center>
</form>
@else
<h3 class="ui blue center aligned header">Bạn cần đăng nhập để bình luận</h3>
@endif

    </div>
  </div>

        

      </div>

</div>

 @include('user.layouts.footer')

 <script>
 document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const quantity = document.querySelector('#addToCartForm input[name="quantity"]').value;
    addToCart('{{ $bookdetail->id }}', quantity);
    
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


  document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Retrieve form data
    const commentContentTextarea = document.querySelector('#commentForm textarea[name="comment_content"]');
    const ratingInput = document.querySelector('#commentForm input[name="rating"]')
    const rating = ratingInput.value;
    const commentContent = commentContentTextarea.value;
    const userName = document.querySelector('#commentForm input[name="user_name"]').value;

    // Perform AJAX request
    fetch('{{URL::to('/dangbinhluan/'.$bookdetail->id)}}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        rating: rating,
        comment_content: commentContent
      })
    })
    .then(response => response.json())
    .then(data => {
      // Handle response from the server
      const commentDate = data.comment_date;
      let stars = '';
for (let i = 0; i < rating; i++) {
    stars += '<i class="yellow star icon"></i>';
}
const commentsElement = document.getElementById('comments');
      const html = `<div class="comment">
    <a class="avatar">
    <i class="user big outline icon"></i>
    </a>
    <div class="content">
      <a class="author">${userName}</a>
      <div class="metadata">
      <span class="date">${commentDate}</span>
      ${stars}
      
      </div>
      <div class="text">
        <p>${commentContent}</p>
      </div>
    </div>
 </div>`
      commentsElement.insertAdjacentHTML('afterbegin', html);
      document.getElementById('comments-segment').scrollIntoView({ behavior: 'smooth', block: 'start' });
      commentContentTextarea.value = ''
      var noCommentsDiv = document.getElementById('no_comments_text');
if (noCommentsDiv) {
  noCommentsDiv.style.display = "none";
}
      $('.ui.rating')
  .rating('clear rating', true);
      successAlert("Đăng bình luận thành công !");
    })
    .catch(error => {
      errorAlert("Lỗi, đăng bình luận không thành công !");
    });
  });

  $('.rating').rating({
    initialRating: 0,
    maxRating: 5
  });

  const rateTextArr = ['Rất tệ', 'Tệ', 'Ổn', 'Tốt', 'Rất tốt'];
  for (let i = 1; i <= $('.rating').children().length; i++) {
    $('.rating i:nth-child(' + i + ')').click(function() {
      $("#comm input[name*='rating']").val(i);
      $('#rate_text').text(rateTextArr[i - 1]);
    });
  }

</script>







