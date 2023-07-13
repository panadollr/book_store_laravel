@include('user.layouts.header')

<style>
  .index.cards{
   
  }
</style>

<body>

<h1 class="ui center aligned header">Sách mới nhất</h1>

<center>

<div class="ui five doubling special index cards">
@foreach($lastest_books as $book)
<div class="card" href="{{ url('chitietsach/'.$book->id)}}">
      <div class="ui move down instant reveal image">
      <img src="{{$book->book_image}}" class="visible content" style="object-fit: cover;height: 350px;">
        <div class="hidden center aligned content" style="background:#2185d0;height:100%;padding:10px;">
        <br><br>
          <h3 class="ui inverted header">{{Str::limit($book->book_title,70)}}</h3>
          <h3 class="ui inverted header"> 
          <i class="money bill alternate icon"></i>     
          {{number_format($book->book_price)}} đ 
        </h3>
          <a onclick="window.location.href='{{ url('chitietsach/'.$book->id) }}'" 
          class="ui right labeled icon fluid black button">
          <i class="right arrow icon"></i>
          Xem
        </a>
        </div>
</div>
  </div>
  @endforeach
</div>


<hr>

<h1 class="ui center aligned header">Sách bán chạy nhất</h1>
@if(count($sellest_books) > 0)
<div class="ui five doubling special index cards" >
@foreach($sellest_books as $book)
  <div class="card" href="{{ url('chitietsach/'.$book->id)}}">
      <div class="ui move up instant reveal image">
      <img src="{{$book->book_image}}" class="visible content" style="object-fit: cover;height: 350px;">
        <div class="hidden center aligned content" style="background:#1b1c1d;height:100%;padding:10px">
        <br><br>  
          <h3 class="ui blue header" s>{{Str::limit($book->book_title,50)}}</h3>
          <h3 class="ui blue header"> 
          <i class="money bill alternate icon"></i>    
          {{number_format($book->book_price)}} đ 
        </h3>
          <h4 class="ui blue header">
          Đã bán: {{$book->quantity}}</h4>
          <a onclick="window.location.href='{{ url('chitietsach/'.$book->id) }}'" 
          class="ui right labeled icon fluid blue button">
          <i class="right arrow icon"></i>
          Xem
        </a>
        </div>
</div>
  </div>
  @endforeach
</div>
@else
<h3 class="ui center aligned header" style="padding:60px">Chưa có sản phẩm !</h3>
@endif


</center>
        </body>
</html>


@include('user.layouts.footer')


