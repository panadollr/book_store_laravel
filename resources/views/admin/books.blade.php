 @include('admin.layouts.sidebar')
 <title>Table</title>

 <div class="pusher" style="margin-right: 400px;margin-top: 30px;">
 <table class="ui celled padded table" style="text-align:center;border: 1px solid black;" >
    <h1 class="ui center aligned header">Bảng sản phẩm</h1>
  <thead>
    <tr><th class="single line">Mã sản  phẩm</th>
    <th>Tên sản phẩm</th>
    <th>Ảnh</th>
     <th>Giá sản phẩm</th>
     <th></th>
     <th></th>
  </tr></thead>
  <center><button id="themsanpham" class="ui green button">Thêm sản phẩm</button>
<div class="ui input">
  <input type="text" id="book_name" >
</div>
  </center>
<tbody id="countryList">
  
</tbody>

  <tbody id="bks">
    @foreach($allbooks as $book)
    <tr >
      <td >
     <a name="publisherid">{{$book->book_isbn}}</a>
      </td>
      <td >
     <h4 class="ui center aligned header">{{$book->book_title}}</h4>
      </td>
      <td>
        <img src="{{$book->book_image}}" class="ui tiny centered image" >
      </td>
        <td>{{number_format($book->book_price)}} đ</td>
        <td><a style="display:none" href="{{URL::to('/edit_book/'.$book->book_isbn.'.'.$book->publisherid)}}" class="ui blue button">Sửa</a>
<button  class="ui blue button" id="editbutton" data-book_id="{{$book->id}}">Sửa</button>
        </td>
        <td><a  class="ui red button" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này ?')" href="{{URL::to('/delete_book_table1/'.$book->book_isbn)}}">Xóa</a></td>
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

</table>
</div>

<script type="text/javascript">
    document.getElementById('a1').className='active item';
</script>


<div class="ui overlay fullscreen modal" id="add_book" >
  <div class="ui center aligned header" style="height: 125px;font-size: 4.5ch;padding: 45px;">Thêm sản phẩm mới</div>
  <div class="center aligned scrolling content" style="background: #DCDCDC;border: 1px solid black;">
   
  <center> <form class="ui form" method="POST" action="{{URL::to('/save_book')}}" enctype="multipart/form-data" style="width: 600px;background: #DCDCDC;">
  @csrf 
    <div class="field">
       <label>Mã sản phẩm</label>
    <input type="text" name="book_isbn" placeholder="Mã sản phẩm" required="">
  </div>
   <div class="field">
     <label>Tên sản phẩm</label>
    <input type="text" name="book_title" placeholder="Tên sản phẩm" required="">
  </div>
  <div class="field">
     <label>Tên tác giả</label>
    <input type="text" name="book_author" placeholder="Tên tác giả" required="">
  </div>
   <div class="field">
     <label>Ảnh sản phẩm</label>
    <input type="text" name="book_image" required="" placeholder="Link ảnh">
  </div>
  <div class="field">
     <label>Mô tả sản phẩm</label>
    <textarea name="book_descr"  placeholder="Mô tả sản phẩm" ></textarea>
  </div>
  <div class="field">
     <label>Giá sản phẩm</label>
    <input  type="text" name="book_price" placeholder="Giá sản phẩm" required="">
  </div>

  <div class="field">
    <label>Chọn nhà xuất bản</label>
    <select class="ui fluid dropdown" name="publisherid" >
      @foreach($publisherid as $key => $publisher_id)
        <option value="{{$publisher_id->publisherid}}">{{$publisher_id->publisher_name}}</option>
        @endforeach

      </select>
  </div>
    <div class="ui error message"></div>
<div class="actions">
   <button class="ui blue submit button" type="submit">Thêm sản phẩm</button>
</form>
    <div class="ui black deny button">
      Thoát
    </div>
</center>

  </div>
</div>

<script type="text/javascript">
  $('#themsanpham').click(function(){
$('#add_book')
  .modal('show')
;
  })
</script>

<script type="text/javascript">
     $(document).ready(function(){

   $('#book_name').keyup(function(){ 
    var query = $(this).val(); //lấy gía trị ng dùng gõ
    if(query != '' && query.length >0) //kiểm tra khác rỗng thì thực hiện đoạn lệnh bên dưới
    {
      document.getElementById('bks').style.display="none";
     var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
     $.ajax({
      url:"{{ url('/timkiem_sach_ajax') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
      method:"POST", // phương thức gửi dữ liệu.
      data:{query:query, _token:_token},
      success:function(data){ //dữ liệu nhận về  
        document.getElementById('countryList').style.display="table-row-group";
       $('#countryList').html(data); //nhận dữ liệu dạng html và gán vào cặp thẻ có id là countryList
     }
   });
   }
   else if(query.length ==0 || query == '' ){
    document.getElementById('bks').style.display="table-row-group";
     document.getElementById('countryList').style.display='none';
        }
   
 });
 });

      $(document).on('click','#editbutton',function(){
    var bookid = $(this).data('book_id'); 
     $.ajax({
      url:"{{ url('/edit_sach_ajax') }}", 
      method:"GET", 
      data:{bookid:bookid},
      success:function(data){ 
        $('#bookList').modal('show');
;$('#bookList').html(data);
     }
   });
   
 });
  </script>

  <div class="ui overlay fullscreen modal" id="bookList" >
</div>
