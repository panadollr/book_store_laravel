<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\CardPayment;
use App\Models\Shipping;

class UserController extends Controller
{
    
    public function logout(){
        Session::put('user', null);
        return redirect()->back()->with('success', "Đã đăng xuất !");
    }
   
    public function checkout()
    {
     $carts = Session::get('cart');
     if($carts){
        return view('user.checkout.checkout',compact('carts'));
     }else {
       return redirect('/');
     }
       
    }

    public function save_checkout(Request $request)
    {
     $user = Session::get('user');

//payment
$payment_data=array();
        $payment_data['payment_method']="Thanh toán khi nhận hàng";
        $payment_id = Payment::insertGetId($payment_data); 

//order
        $order_data=array();
        $order_data['payment_id']=$payment_id; 
        $order_data['order_total']=$request->order_total;
        $order_data['order_status']='Đang chờ xác nhận'; 
        $order_id = Order::insertGetId($order_data);

//shipping
        $shipping_data=array();
        $shipping_data['shipping_name']=$request->shipping_name;
        $shipping_data['shipping_address']=$request->shipping_address;
         $shipping_data['shipping_city']=$request->shipping_city;
        if($request->shipping_note == null ){
            $shipping_data['shipping_note'] ="Không có";
        } else{
            $shipping_data['shipping_note']=$request->shipping_note;
        };
        $shipping_data['order_id']=$order_id; 
        $shipping_data['user_id'] = $user->id;

        $shipping_id = Shipping::insertGetId($shipping_data);
 
//order_details
        $order_detail_data=array();
        $carts= Session::get('cart');
        foreach($carts as $cart){
        $order_detail_data['order_id']=$order_id; 
        $order_detail_data['product_id']=$cart['book_id']; 
        $order_detail_data['product_name']=$cart['book_name'];  
        $order_detail_data['product_price']=$cart['book_price'];  
        $order_detail_data['product_sales_quantity']=$cart['book_amount'];
         $order_details_id = OrderDetails::insertGetId($order_detail_data);
        } 

 //paypal 
        if($payment_data['payment_method']=='Thanh toán bằng Paypal'){

 $card_payment_data=array();
        $card_payment_data['order_id']=$order_id; 
        $card_payment_data['card_name']=$request->card_name;
          $card_payment_data['card_number']=$request->card_number;
            $card_payment_data['exp_month']=$request->exp_month;
              $card_payment_data['exp_year']=$request->exp_year;
        $card_payment_data['cvv']=$request->cvv;  
        $card_payment_data['card_status']='Đang chờ xác nhận'; 
    CardPayment::insertGetId($card_payment_data);
       }  

Session::put('cart',null); 
         return Redirect('/donhang')->with('success', 'Cảm ơn bạn đã mua hàng !'); 
    }
   

    public function update_user(Request $request,$id){
         $data=array();
         $data['name']=$request->name;
         $data['email']=$request->email;
         DB::table('users')->where('id',$id)->update($data);
         return Redirect::back()->withErrors(['msg' => 'Đã cập nhật thông tin tài khoản']);
    }

   public function change_pass(Request $request,$id){
    $data=array();
        $data['password']=bcrypt($request->new_pass);
       DB::table('users')->where('id',$id)->update($data);

 return Redirect::back()->withErrors(['msg' => 'Đã cập nhật mật khẩu tài khoản']);

   }

   public function user_order(Request $request){
    $user = Session::get('user');
    $status = $request->input('status');
    $user_orders_table = Order::join('tbl_shipping','tbl_order.order_id','=','tbl_shipping.order_id')
    ->where('user_id',$user->id);
    if($status == 'danggiaohang'){
        $user_orders = $user_orders_table
        ->where('order_status', 'Đang giao hàng')->get();
    } else if($status == 'dagiaohang'){
        $user_orders = $user_orders_table
        ->where('order_status', 'Đã giao hàng')->get();
    } else {
        $user_orders = $user_orders_table
        ->where('order_status', 'Đang chờ xác nhận')->get();
    }
    $order_details = OrderDetails::join('books', 'tbl_order_details.product_id', '=', 'books.id')
    ->get();
    return view('user.user_order',compact('user','user_orders', 'order_details'));
  }

     public function delete_user_order($payment_id){
        DB::table('tbl_payment')->where('payment_id', $payment_id)->delete();
    return redirect('/donhang')->with('success','Hủy đơn hàng thành công !');
     }
     

    public function post_comment(Request $request,$book_id){
        $userSession = Session::get('user');
        $data['book_id']=$request->book_id;
        $data['user_id']=$userSession->id;
          $data['comment_content']=$request->comment_content;   
            $data['comment_rating']=$request->rating;
    $comment_id = Comment::insertGetId($data);
    $comment = Comment::where('comment_id','=',$comment_id)->first();

    return response()->json($comment);
    }

    public function account_settings_index(){
        return view('user.user_account_settings');
    }


}

