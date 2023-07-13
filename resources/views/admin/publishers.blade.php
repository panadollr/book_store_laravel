 @include('admin.layouts.sidebar')
 <title>Table</title>

 <div class="pusher" style="margin-right: 400px;margin-top: 30px;">
   
 <table class="ui celled padded table" style="text-align:center;border: 1px solid black;" >
    <h1 class="ui center aligned header">Bảng nhà xuất bản</h1>
    <center><button class="ui green button" onclick="$('#addpub').modal('show')">Thêm nhà xuất bản</button>
<div class="ui input">
  <input type="text" name="" id="country_name" placeholder="Tìm kiếm" >
</div>
    </center>


    <div class="ui mini modal" id="addpub" style="height: 250px;margin-left: 450px;margin-top: 100px;">
  <div class="center aligned header">Thêm nhà xuất bản</div>
  <div class="center aligned content">
    <form class="ui form" method="POST" action="{{url('/add_publisher')}}">
      @csrf
      <label>Tên nhà xuất bản</label>
      <div class="field">
        <div class="ui focus input">
           <input type="text" name="publisher_name" style="width:300px">
        </div>
      </div>
  </div>
  <div class="center aligned actions">
    <button type="submit" class="ui green button">Thêm nhà xuất bản</button>
     </form>
    <div class="ui red cancel button">Hủy</div>
  </div>
</div>
  <thead>
    <tr><th class="single line">Tên nhà phát hành</th>
    <th></th>
     <th></th>
  </tr></thead>
  <tbody id="countryList">
  
  </tbody>

  <tbody id="pubs" >
    @foreach($allpublishers as $pub)
    <tr >
      <td contenteditable>
     <h4 class="ui center aligned header">{{$pub->publisher_name}}</h4>
      </td>
        <td>

          <a style="display: none;" href="{{URL::to('/edit_publisher/'.$pub->publisherid)}}" class="ui blue button">Sửa</a>
   <button class="ui blue button" id="editbutton" data-pub_id="{{$pub->publisherid}}">Sửa</button>
        </td>
        <td><a  class="ui red button" onclick="return confirm('Bạn chắc chắn muốn xóa nhà xuất bản {{$pub->publisher_name}} ?')" href="{{URL::to('/delete_publisher/'.$pub->publisherid)}}">Xóa</a></td>
    </tr>
        @endforeach
  </tbody>

  <tfoot>
  <tr>
    <th colspan="6">
      <div class="ui right floated pagination menu">
        @if ($allpublishers->currentPage() > 1)
          <a href="{{ $allpublishers->previousPageUrl() }}" class="item">
            <i class="left chevron icon"></i>
          </a>
        @endif

        @for ($i = 1; $i <= $allpublishers->lastPage(); $i++)
          <a href="{{ $allpublishers->url($i) }}" class="item {{ $allpublishers->currentPage() == $i ? 'active' : '' }}">
            {{ $i }}
          </a>
        @endfor

        @if ($allpublishers->hasMorePages())
          <a href="{{ $allpublishers->nextPageUrl() }}" class="item">
            <i class="right chevron icon"></i>
          </a>
        @endif
      </div>
    </th>
  </tr>
</tfoot>
</table></div>

<script type="text/javascript">
    document.getElementById('a0').className='active item';
</script>

<script type="text/javascript">
     $(document).ready(function(){

   $('#country_name').keyup(function(){ //bắt sự kiện keyup khi người dùng gõ từ khóa tim kiếm
    var query = $(this).val(); //lấy gía trị ng dùng gõ
    if(query != '' && query.length >0) //kiểm tra khác rỗng thì thực hiện đoạn lệnh bên dưới
    {
      document.getElementById('pubs').style.display="none";
     var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
     $.ajax({
      url:"{{ url('/timkiem_nxb_ajax') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
      method:"POST", // phương thức gửi dữ liệu.
      data:{query:query, _token:_token},
      success:function(data){ //dữ liệu nhận về  
        document.getElementById('countryList').style.display="table-row-group";
       $('#countryList').html(data); //nhận dữ liệu dạng html và gán vào cặp thẻ có id là countryList
     }
   });
   }
   else if(query.length ==0 || query == '' ){
    document.getElementById('pubs').style.display="table-row-group";
     document.getElementById('countryList').style.display='none';
        }
   
 });
   /*$(document).on('click', 'tr', function(){  
    $('#country_name').val($(this).text());  
          
  });*/  

 });
  </script>

  <script type="text/javascript">
  
 $(document).on('click','#editbutton',function(){
    var publisherid = $(this).data('pub_id'); 
     $.ajax({
      url:"{{ url('/edit_nxb_ajax') }}", 
      method:"GET", 
      data:{publisherid:publisherid},
      success:function(data){ 
        $('#pubsList').modal('show');
;$('#pubsList').html(data);
     }
   });
   
 });

  </script>

  <div class="ui mini modal" id="pubsList" style="height: 250px;margin-left: 40%;margin-top: 8%;">
</div>