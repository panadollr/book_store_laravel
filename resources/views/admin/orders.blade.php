 @include('admin.layouts.sidebar')
 <title>Table</title>

 <div class="pusher" style="margin-right: 400px;">
   
 <table class="ui celled padded table" style="text-align:center;" >
    <br>
    <h1 class="ui center aligned header">Liệt kê đơn hàng</h1>
  <thead>
    <tr><th class="single line">Mã đơn hàng</th>
    <th class="single line">Tên người đặt</th>
    <th>Tổng tiền(VNĐ)</th>
    <th>Tình trạng</th>
     <th>Xem chi tiết</th>
     <th>Tùy chỉnh</th>
    
  </tr></thead>
  <tbody>
    @foreach($allbooks as $book)
    <tr >
       <td >
     <a >{{$book->order_id}}</a>
      </td>
      <td >
     <a name="publisherid">{{$book->shipping_name}}</a>
      </td>
      <td >
     <h4 class="ui center aligned header">{{$book->order_total}}</h4>
      </td>
        <td> 

@if($book->order_status =='Đang chờ xác nhận' || $book->order_status =='Đang giao hàng') 
<br>         
<div class="ui blue sliding indeterminate progress" id="progress">
    <div class="bar">
        <div class="progress" >{{$book->order_status}}...</div>
    </div>
</div>
@endif

@if($book->order_status =='Đã giao hàng')          
<div  class="ui large green label" id="successorder">
   {{$book->order_status}}</div>
@endif

<h3 id="complete_order" style="color:green;display: none">{{$book->order_status}}</h3>
</td>
        <td><a style="display: none;" href="{{URL::to('/view_order/'.$book->order_id)}}" class="ui blue button">Xem chi tiết</a>
            <button class="ui blue button" id="detail_order" data-order_id="{{$book->order_id}}">Xem chi tiết</button>
        </td>
       <td>
        @if($book->order_status =='Đang chờ xác nhận')  
        <a id="check_order" href="{{URL::to('/delivery_order/'.$book->payment_id)}}" class="ui green button">Xác nhận và giao  hàng</a>
        @endif


@if($book->order_status =='Đang giao hàng')     
        
<a class="ui green button" href="{{URL::to('/complete_order/'.$book->order_id)}}">Duyệt đơn hàng</a>
        @endif


       </td>
    </tr>
        @endforeach
  </tbody>

  <tfoot>
  <tr>
    <th colspan="6">
      <div class="ui right floated pagination menu">
        @if ($allbooks->currentPage() > 1)
          <a href="{{ $allbooks->previousPageUrl() }}" class="item">
            <i class="left chevron icon"></i>
          </a>
        @endif

        @for ($i = 1; $i <= $allbooks->lastPage(); $i++)
          <a href="{{ $allbooks->url($i) }}" class="item{{ $allbooks->currentPage() == $i ? ' active' : '' }}">
            {{ $i }}
          </a>
        @endfor

        @if ($allbooks->hasMorePages())
          <a href="{{ $allbooks->nextPageUrl() }}" class="item">
            <i class="right chevron icon"></i>
          </a>
        @endif
      </div>
    </th>
  </tr>
</tfoot>
 
</table></div>

<script type="text/javascript">
    document.getElementById('a2').className='active item';
</script>

 <script type="text/javascript">
  
 $(document).on('click','#detail_order',function(){
    var order_id = $(this).data('order_id'); 
     $.ajax({
      url:"{{ url('/detail_order_ajax') }}", 
      method:"GET", 
      data:{order_id:order_id},
      success:function(data){ 
        $('#detail_order_form').html(data);
        $('.ui.modal').modal('show');
;
     }
   });
   
 });

  </script>

  <div class="ui large modal" id="detail_order_form">
</div>