<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Social;
use App\Login;
use Socialite;
use Mail;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  
    public function loginindex(){
        return view('admin.login.login');
    }

    public function login_authentication(Request $request){
      $admin_email = $request->admin_email;
      $admin_password= md5($request->admin_password);
      $result= DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
      if($result){
         Session::put('admin_name',$result->admin_name);
         Session::put('id',$result->id);
          return Redirect::to('admin/tong_quan');
      }else{
          return Redirect::to('admin')->with('error','Tên tài khoản hoặc mật khẩu bị sai !');
      }
  }

    public function index(){
$range = \Carbon\Carbon::now()->calendar();
        $orderDay = DB::table('tbl_order_details')
                    ->select(DB::raw('date(tbl_order.date) as getDay'), DB::raw('sum(product_price * product_sales_quantity) as value'), DB::raw('COUNT(*) as value2'))
                    ->join('tbl_order','tbl_order.order_id','tbl_order_details.order_id')
                    ->where('tbl_order.date', '>=', $range)
                    ->where('tbl_order.order_status','=','Đã giao hàng')
                    ->groupBy('getDay')
                    ->orderBy('getDay', 'ASC')
                    ->get();

$game = DB::table('books')
->orderBy('book_title','desc')->get();

$testgame = DB::table('tbl_order_details')
->join('books','books.id','=','tbl_order_details.product_id')
->select(DB::raw('sum(product_sales_quantity) as quantity'),DB::raw('book_title as book_title')
,DB::raw('product_id as product_id'))
->join('tbl_order','tbl_order.order_id','=','tbl_order_details.order_id')
->where('tbl_order.order_status','=','Đã giao hàng')
->groupBy('book_title','product_id')
->get();


        $books=DB::table('books')->count();
        $publishers=DB::table('publishers')->count();
        $orders=DB::table('tbl_order')->count();

         $totalmoney=DB::table('tbl_order_details')->select(DB::raw('sum(product_price*product_sales_quantity) as order_total'))
->join('tbl_order','tbl_order.order_id','=','tbl_order_details.order_id')
->where('order_status','Đã giao hàng')
         ->first();

        return view('admin.dashboard',compact('totalmoney','books','publishers','orders','game','testgame','orderDay'));
    }

    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('/admin_dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }

    public function logout(){
         $this ->AuthLogin();
         Session::put('admin_name',null);
         Session::put('id',null);
         return Redirect::to('/admin');
    }
 
 public function publishers(){
     $this ->AuthLogin();
        $allpublishers = DB::table('publishers')->orderBy('publisherid','desc')->paginate(5);
        return view('admin.publishers',compact('allpublishers'));
 }

 public function add_publisher(Request $request){
    $data['publisher_name']=$request->publisher_name;
    DB::table('publishers')->insert($data);
    return Redirect::to('/show_publishers')->with('success','Đã thêm nhà xuất bản mới');
 }
       public function books(){
          $this ->AuthLogin();
          $publisherid = DB::table('publishers')->orderBy('publisherid','desc')->get();
        $allbooks = Book::orderBy('books.id','desc')->paginate(3);
        return view('admin.books',compact('allbooks','publisherid'));
     }


     public function save_book(Request $request){
      $data=array();
      $data=$request->validate([
     'book_isbn' =>'unique:books',
      ],   
     [
'book_isbn.unique' => 'Mã sản phẩm đã tồn tại, vui lòng nhập mã khác !',
      ],
  );
        $data['book_isbn']=$request->book_isbn;
        $data['book_title']=$request->book_title;
        $data['book_author']=$request->book_author;
        $data['book_descr']=$request->book_descr;
        $data['book_price']=$request->book_price;
         $data['publisherid']=$request->publisherid;
         $get_image= $request-> file('book_image');
        if ($get_image) {
             $new_image = rand(0,99).'.'.$get_image->getClientOriginalExtension();
             $get_image->move('resources/img/',$new_image);
             $data['book_image']= $new_image;
              DB::table('books')->insert($data);
               return Redirect::to('/show_table.1')->with('success','Thêm sản phẩm thành công !');

         } 
         $data['book_image']= '';
         DB::table('books')->insert($data);
       $data['book_isbn']=Session::get('book_isbn');
 return Redirect::to('/show_table.1')->with('success','Thêm sản phẩm thành công !');
     }


     public function save_publisher(Request $request){
        $pubid = DB::table('publishers')->count()+1;
      $data2=array();
      $data2=$request->validate([
     'publisher_name' =>'unique:publishers',
      ],   
     [
'publisher_name.unique' => 'Tên nhà xuất bản đã tồn tại, vui lòng nhập tên khác !',
      ],
  );

        $data2['publisherid']= $pubid;
        $data2['publisher_name']=$request->publisher_name;
        
         DB::table('publishers')->insert($data2);
        return Redirect::to('/add_book')->with('success','Đã thêm nhà xuất bản mới, vui lòng kiểm tra lại !');

     }


     public function update_book(Request $request,$book_id){
        $data['book_isbn']=$request->book_isbn;
        $data['book_title']=$request->book_title;
        $data['book_author']=$request->book_author;
        $data['book_descr']=$request->book_descr;
        $data['book_price']=$request->book_price;
         $data['publisherid']=$request->publisherid;
         $data['book_image']= $request->book_image;
         DB::table('books')->where('book_isbn',$book_id)->update($data);
        return Redirect::to('/show_table.1')->with('success','Cập nhật sản phẩm thành công !');;
     }


     public function update_publisher(Request $request,$publisher_id){
        $data['publisher_name']=$request->publisher_name;
        DB::table('publishers')->where('publisherid',$publisher_id)->update($data);
        return Redirect::to('/show_publishers')->with('success','Đã cập nhật nhà xuất bản');
     }

     public function delete_publisher($publisher_id){
       DB::table('publishers')->where('publisherid',$publisher_id)->delete();
       return Redirect::to('/show_publishers')->with('success','Xóa nhà xuất bản thành công !');
     }

     public function delete_book_table1($book_id){
       DB::table('books')->where('book_isbn',$book_id)->delete();
       return Redirect::to('/show_table.1')->with('success','Xóa sản phẩm thành công !');
     }


     public function orders(){
         $this ->AuthLogin();
        $allbooks = DB::table('tbl_shipping')->join('tbl_order','tbl_order.order_id','=','tbl_shipping.order_id')->orderBy('tbl_shipping.order_id','desc')->paginate(3);
        $order_details=DB::table('tbl_order_details')->get();
        return view('admin.orders',compact('allbooks','order_details'));
     }

      public function delivery_order($payment_id){
        $this ->AuthLogin();
         $data=array();
         $data['order_status']= 'Đang giao hàng';
     DB::table('tbl_order')
     ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
     ->where('tbl_order.payment_id',$payment_id)
     ->update($data);
              return Redirect::to('/order')->with('success','Đã tiến hành giao hàng !');;
     }

     public function complete_order(Request $request,$order_id){
         $data=array();
         $data['order_status']= 'Đã giao hàng';
     DB::table('tbl_order')
     ->where('order_id',$order_id)
     ->update($data);
              return Redirect::to('/order')->with('success','Giao hàng thành công !');;
     }
     public function comments(){
        $allcomments= Comment::join('books','tbl_comment.book_id','=','books.id')->paginate(2);
        $comments =DB::table('tbl_reply_comment')->get();
        return view('admin.comments',compact('allcomments','comments'));
     }

     public function reply_comment(Request $request){
         $data=array();
          $data['comment_id']=$request->comment_id;
        $data['reply_comment_content']=$request->reply_comment_content;
    DB::table('reply_comment')->insertGetId($data);

    return Redirect::to('/xembinhluan')->with('success','Đã trả lời bình luận');
     }

     public function check_comment($comment_id){
        $data=array();
         $data['comment_status']= 1;
          DB::table('tbl_comment')
     ->where('comment_id',$comment_id)
     ->update($data);
              return Redirect::to('/xembinhluan')->with('success','Đã phê duyệt bình luận');
     }

     public function uncheck_comment($comment_id){
        $data=array();
         $data['status']= '0';
          DB::table('post_comment')
     ->where('comment_id',$comment_id)
     ->update($data);
              return Redirect::to('/xembinhluan')->with('success','Đã hủy chọn phê duyệt bình luận');
     }

     public function delete_comment($comment_id){
 DB::table('post_comment')->where('comment_id',$comment_id)->delete();
        return Redirect::to('/xembinhluan')->with('success','Đã xóa bình luận');
     }

     public function delete_reply_comment($reply_comment_id){
 DB::table('reply_comment')->where('reply_comment_id',$reply_comment_id)->delete();
        return Redirect::to('/xembinhluan')->with('success','Đã xóa bình luận');;
     }

    public function view_contact(){
        $allcomments=DB::table('contact')->get();
        return view('admin.xemphanhoi')->with('allcomments',$allcomments);
    }

    public function answer_contact(Request $request,$contact_id){

 $to_name='VKUBook Store';
        $to_email='cupleofgamer@gmail.com';
        $data2=array("name"=>$request->email,"body"=>$request->answer);
        Mail::send('pages.user.send_mail_contact',$data2,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('VKUBook Store đã trả lời bạn');
            $message->from($to_email,$to_name);
        });

        $data['answer']=$request->answer;
        $data['status']='Đã trả lời';
        DB::table('contact')
     ->where('id',$contact_id)
     ->update($data);
 return Redirect::to('/xemphanhoi')->with('success','Đã trả lời phản hồi');
    }

     public function timkiem_nxb_ajax(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('publishers')
            ->where('publisher_name', 'LIKE', "%{$query}%")
            ->get();
            $output = '<div>';
                foreach($data as $row)
            {
               $output .= '

<tr>
      <td >
     <h4 class="ui center aligned header">'.$row->publisher_name.'</h4>
      </td>
        <td><a style="display:none" href="/edit_publisher/'.$row->publisherid.'" class="ui blue button">Sửa</a></td>
        <td><a  class="ui red button" onclick="return confirm("Bạn chắc chắn muốn xóa nhà xuất bản này ?")" href="/delete_publisher/'.$row->publisherid.'">Xóa</a></td>
            
              </tr>';
           }
           $output .= '</div>';
           echo $output;
       }

     }


     public function timkiem_sach_ajax(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('books')
            ->where('book_title', 'LIKE', "%{$query}%")
            ->get();
            $output = '<div>';
                foreach($data as $row)
            {
               $output .= '

<tr >
      <td >
     <a name="publisherid">'.$row->book_isbn.'</a>
      </td>
      <td >
     <h4 class="ui center aligned header">'.$row->book_title.'</h4>
      </td>
      <td>
        <img src="resources/img/'.$row->book_image.'" class="ui tiny centered image" >
      </td>
        <td>'.number_format($row->book_price).' đ</td>
        <td><a href="/edit_book/'.$row->book_isbn.'.'.$row->publisherid.'" class="ui 
        blue button">Sửa</a></td>
        <td><a  class="ui red button" onclick="return confirm("Bạn chắc chắn muốn xóa sản phẩm này ?")" href="/delete_book_table1/'.$row->book_isbn.'">Xóa</a></td>
    </tr>';
           }
           $output .= '</div>';
           echo $output;
       }
     }


      public function edit_nxb_ajax(Request $request){
           if($request->get('publisherid'))
        {
            $publisherid = $request->get('publisherid');
            $data = DB::table('publishers')
            ->where('publisherid',$publisherid)
            ->get();
            $output = '';
                foreach($data as $row)
            {
               $output .= '
               <h3 class="center aligned header">Cập nhật nhà xuất bản</h3>
        <div class="center aligned content">
        <form class="ui form" method="POST" action="update_publisher/'.$row->publisherid.'">
        '.csrf_field().'
        <div class="field">
        <input value="'.$row->publisher_name.'" name="publisher_name">
        </div>
        <div class="field">
        <button class="ui green button">Cập nhật</button>
        </div>
        </form>
        </div>
            
              ';
           }
           $output .= '';
           echo $output;
       }

     }



      public function edit_sach_ajax(Request $request){
           if($request->get('bookid'))
        {
            $bookid = $request->get('bookid');
            $data = DB::table('books')
            ->join('publishers','publishers.publisherid','=','books.publisherid')
            ->where('id',$bookid)
            ->get();
            $pub=DB::table('publishers')->get();
            $output = '';
                foreach($data as $row)
            {
               $output .= '
               <h3 class="center aligned header">Cập nhật sản phẩm</h3>
        <div class=" scrolling center aligned content" style="background: #DCDCDC;">
        <center><form class="ui form" method="POST" action="update_book/'.$row->book_isbn.'" enctype="multipart/form-data" style="width:600px">
 '.csrf_field().'
    <div class="field">
      <label>Mã sách</label>
    <input type="text" name="book_isbn" placeholder="Mã sách" value="'.$row->book_isbn.'">
  </div>
   <div class="field">
    <label>Tên sách</label>
    <input type="text" name="book_title" placeholder="Tên sách" value="'.$row->book_title.'">
  </div>
  <div class="field">
    <label>Tên tác giả</label>
    <input type="text" name="book_author" placeholder="Tác giả" value="'.$row->book_author.'">
  </div>
   <div class="field">
    <label>Ảnh sản phẩm</label>
    <input type="text" name="book_image" placeholder="Link ảnh" value="'.$row->book_image.'">
  </div>
  <div class="field">
    <label>Mô tả</label>
    <textarea type="text" name="book_descr" placeholder="Mô tả" >'.$row->book_descr.'</textarea>
  </div>
  <div class="field">
    <label>Giá sản phẩm</label>
    <input type="text" name="book_price" placeholder="Giá" value="'.$row->book_price.'">
  </div>
  <div class="field" >
    <label>Chọn nhà xuất bản</label>
    <select class="ui fluid dropdown" name="publisherid">
      <option value="'.$row->publisherid.'" >'.$row->publisher_name.' </option>';
        foreach($pub as $p){
      if($p ->publisher_name != $row->publisher_name):
      $output .='<option value="'.$p->publisherid.'">'.$p->publisher_name.' </option>';
endif;
        }
      $output.='</select>
  </div>
  <button class="ui blue button" type="submit" name="add_book">Cập nhật sản phẩm</button>
        </div>
        <div class="right aligned actions" style="background:#2185d0">
  <div class="ui red cancel button">
      <i class="remove icon"></i>
      Thoát
    </div>
</form></center>
</div>
            
              ';
           }
           $output .= '';
           echo $output;
       }

     }

      public function detail_order_ajax(Request $request){
            $order_id = $request->get('order_id');
            $data = DB::table('tbl_shipping')
        ->where('tbl_shipping.order_id',$order_id)->first();
        $data2=DB::table('tbl_order_details')
        ->where('order_id',$order_id)->get();
            $output = '';
               
               $output .= '
                <i class="close icon"></i>
     <h3 class="ui center aligned header">Thông tin chi tiết đơn hàng<br>Mã đơn hàng : 
     '.$data->order_id.'</h3>
          <div class=" content" style=" background: #DCDCDC;height:100vh">

<table class="ui celled padded table" >
    <h3 class="ui center aligned header">Thông tin vận chuyển</h3>
  <thead>
    <tr><th >Tên người mua</th>
       <th >Địa chỉ giao hàng</th>
        <th >Số điện thoại</th>
           <th >Ghi chú đơn hàng</th>
               <th >Ngày đặt hàng</th>
              <th >Hình thức thanh toán</th>
  </tr></thead>
  <tbody>
    <tr >
      <td >
    '.$data->shipping_name.'
      </td> 
      <td >
    '.$data->shipping_address.', '.$data->shipping_city.'
      </td> 
       <td >
    '.$data->shipping_phone.'
      </td>
        <td >
    '.$data->shipping_note.'
      </td>
      <td >
    '.$data->date.'
      </td>
       <td >
     '.$data->payment_method.'
      </td>    
    </tr>
  </tbody>
</table>

<table class="ui celled  padded table"  >
    <h3 class="ui center aligned header">Chi tiết đơn hàng</h3>
  <thead>
    <tr>
      <th class="single line">Mã sản phẩm</th>
      <th class="single line">Tên sản phẩm</th>
       <th class="single line">Số lượng</th>
        <th class="single line">Tổng giá tiền</th>  
  </tr></thead>';
  foreach($data2 as $da){
    $output.= '<tbody>
    <tr >
      <td >
    '.$da->product_id.'
      </td> 
      <td >
     '.$da->product_name.'
      </td> 
     <td>'.$da->product_sales_quantity.'</td>
     <td>
       '.number_format(((int)$da->product_sales_quantity)*((int)$da->product_price)).' đ
     </td>
    </tr>
  </tbody>';
}
'</table>
          </div>   
              ';
           $output .= '

           ';
           echo $output;
       

     }

}
