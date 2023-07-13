<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\UserController;
use Mail;

class BookController extends Controller
{
  public function __construct()
  {
    $cacheController = new CacheController();
    $cacheController->clearCache();
  }

  public function register_index(){
    return view('user.register');
  }

  public function register_authentication(Request $request){
    $credentials = $request->only('name','email', 'password','phone');
      $credentials['password'] = md5($credentials['password']);
      $password = $request->input('password');
      $re_password = $request->input('re_password');

      if($password == $re_password){
 if(User::insert($credentials)) {
          return redirect('/dangnhap')->with(['success' => 'Đăng ký thành công !']);
      } else {
          return redirect()->back()->with(['error' => 'Đăng ký thất bại !']);
      }
      }else {
        return redirect()->back()->with(['error' => 'Mật khẩu không trùng khớp !']);
      }
     
  }

  public function login_index(){
    return view('user.login');
  }

  public function login_authentication(Request $request)
  {
      $credentials = $request->only('email', 'password');
      $credentials['password'] = md5($credentials['password']);
      $user = User::where($credentials)->first();
  
      if($user){
        Session::put('user', $user);
        return redirect()->intended('/');
      }else {
        return redirect()->back()->withErrors('Tài khoản không tồn tại trong hệ thống !');
      }
  }
  
  
  public function index()
  {
    $lastest_books = Book::select('id','book_title','book_image','book_price')->orderBy('id', 'desc')->paginate(6);

      $sellest_books = Book::join('tbl_order_details', 'tbl_order_details.product_id', '=', 'books.id')
                  ->join('tbl_order', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
                  ->select(DB::raw('sum(product_sales_quantity) as quantity'), 'books.id', 'product_name as book_title', 'book_image', 'book_price')
                  ->where('order_status', '=', 'Đã giao hàng')
                  ->orderBy('quantity', 'desc')
                  ->groupBy('books.id', 'product_name', 'book_image', 'book_price')
                  ->get();
  
      return view('user.index', compact('lastest_books', 'sellest_books'));
  }

     public function books_index(){
return view('user.books');
     }

     public function load_books_by_type($type){
      $ratings=Comment::select(DB::raw('avg(comment_rating) as rating'),'book_id')
->groupBy('book_id')->get();
$all_books = Book::select('id', DB::raw('IF(CHAR_LENGTH(book_title) > 40, CONCAT(SUBSTRING(book_title, 1, 40), "..."), book_title) as book_title')
,'book_price','book_image');
if($type == "gia_thap"){
  $books = $all_books->orderBy('book_price','asc');
} else if($type == "gia_cao"){
  $books = $all_books->orderBy('book_price','desc');
} else if($type == "ban_chay"){
  $books = $all_books->join('tbl_order_details', 'tbl_order_details.product_id', '=', 'books.id')
  ->join('tbl_order', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
  ->select(DB::raw('sum(product_sales_quantity) as quantity'), 'books.id', 'product_name as book_title', 'book_image', 'book_price')
  ->where('order_status', '=', 'Đã giao hàng')
  ->orderBy('quantity', 'desc')
  ->groupBy('books.id', 'product_name', 'book_image', 'book_price');
} 
else {
  $books = $all_books->orderBy('id','desc');
}

      return response()->json(['books' => $books->paginate(12), 'ratings' => $ratings]);
    }


     public function book_details($id){
        $other_books = Book::inRandomOrder()->where('id','!=',$id)->limit(4)->get();
          $bookdetail = Book::find($id);
          $comments=Comment::where('book_id','=',$id)->orderBy('comment_id','desc')->get();
          $reply_comment=DB::table('tbl_reply_comment')->get();
          $users = User::select('id','name')->get();

          return view('user.book_details',compact('bookdetail','other_books','comments','reply_comment','users'));
     }


      public function show_cart(){
        //Session::put('cart', null);
          return view('user.cart');          
     }

     public function save_cart(Request $request, $book_id){
      $book = Book::where('id', $book_id)->first();
      $session_id = substr(md5(microtime()), rand(0,26), 5);
      
      $cart = Session::get('cart') ?? [];
      
      $is_available = false;
      foreach ($cart as $key => $item) {
          if ($item['book_id'] == $book_id) {
              $is_available = true;
              $cart[$key]['book_amount'] += $request->quantity;
              break;
          }
      }
      
      if (!$is_available) {
          $cart[] = [
              'session_id' => $session_id,
              'book_id' => $book_id,
              'book_image' => $book->book_image,
              'manufacturer_id' => $book->id,
              'book_name' => $book->book_title,
              'book_price' => $book->book_price,
              'book_amount' => $request->quantity,
          ];
      }
      
      Session::put('cart', $cart);
      return response()->json($cart);
  }
  

     public function delete_to_cart($id){
      $cart = collect(Session::get('cart', []));
      $cart->forget($id);
      Session::put('cart', $cart->all());
      return response()->json();
     }

      public function update_cart_quantity($id, $quantity) {
    $carts = Session::get('cart', []);
    $cart = $carts[$id];
    
    if ($quantity == 0) {
      unset($carts[$id]);
      $cart = null;
    } else {
        $carts[$id]['book_amount'] = $quantity;
    }
    Session::put('cart', $carts);
   return response()->json(['alert' => "Đã cập nhật giỏ hàng", 'all_carts' => $carts, 'cart' => $cart]);

}

     public function search_index(){
      return view('user.search');
     }

      
     public function search_books(Request $request)
{
    $query = $request->get('query');
    $books = null;
    if ($query) {
        $books = Book::select('id', DB::raw('CONCAT(SUBSTRING(book_title, 1, 40)) as book_title'),
            'book_price', 'book_image')->where('book_title', 'LIKE', "%{$query}%")->get();
    }
    return $books;
}

     
 
}