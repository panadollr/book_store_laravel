 @include('admin.layouts.sidebar')
 <title>Bình luận</title>
 <br>
 <div class="pusher" style="margin-right: 400px;">
   
 <table class="ui celled padded table" style="text-align:center" >
    <h1 class="ui center aligned header">Duyệt và trả lời bình luận</h1>
  <thead>
    <tr>
    <th class="single line">Tên người gửi</th>
    <th>Bình luận</th>
    <th>Đánh giá sao</th>
    <th>Ngày gửi</th>
     <th>Mã sản phẩm</th>
     <th>Tùy chỉnh</th>
    
  </tr></thead>
  <tbody>
    @foreach($allcomments as $comm)
    <tr>
    
      <td >
     <a name="publisherid">{{$comm->user_id}}</a>
      </td>

 <td> <br>
     <h4 class="ui center aligned header" style="margin-top: -20px">{{$comm->comment_content}}</h4>
       @foreach($comments as $key =>$com_reply)
    @if($com_reply->comment_id ==$comm->comment_id)
    <li>{{$com_reply->reply_comment_content}}<a href="{{URL::to('/xoaphanhoi/'.$com_reply->reply_comment_id)}}"><i style="margin-left:5px;color: #db2828;" class="trash alternate icon"></i></a></li>
    @endif
    @endforeach
    <br>
    
     <form action="{{URL::to('traloibinhluan')}}" method="POST">
         @csrf
         <input type="hidden" name="comment_id" value="{{$comm->comment_id}}">
          <textarea style="height:50px" name="reply_comment_content"></textarea>
     <br><br>
     <button class="ui small blue button" type="submit">Trả lời bình luận</button>
     </form>
      </td>

        <td>
             @php 
      $tr=$comm->comment_rating;
      @endphp
     @for($count=0;$count<$tr;$count++)
       <i class="star icon" style="color:orange;font-size:1.4ch"></i>
@endfor
        </td>
      <td >
          <h4>{{$comm->comment_date}}</h4>
      </td>
       <td>
          <h4>{{$comm->id}}</h4>
      </td>
      <td>
          <a style="width:130px" href="{{URL::to('/xoabinhluan/'.$comm->comment_id)}}" class="ui small red button">Xóa bình luận</a>
      </td>
    </tr>
        @endforeach
  </tbody>

  <tfoot>
  <tr>
    <th colspan="6">
      <div class="ui right floated pagination menu">
        @if ($allcomments->currentPage() > 1)
          <a href="{{ $allcomments->previousPageUrl() }}" class="item">
            <i class="left chevron icon"></i>
          </a>
        @endif

        @for ($i = 1; $i <= $allcomments->lastPage(); $i++)
          <a href="{{ $allcomments->url($i) }}" class="item{{ $allcomments->currentPage() == $i ? ' active' : '' }}">
            {{ $i }}
          </a>
        @endfor

        @if ($allcomments->hasMorePages())
          <a href="{{ $allcomments->nextPageUrl() }}" class="item">
            <i class="right chevron icon"></i>
          </a>
        @endif
      </div>
    </th>
  </tr>
</tfoot>
</table></div>

<script type="text/javascript">
    document.getElementById('a5').className='active item';
</script>