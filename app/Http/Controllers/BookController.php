<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UserController;
//use Mail;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
 
  public function register_index(){
    return view('user.register');
  }

  public function register_authentication(Request $request){

    $rules = [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users|max:255',
      'password' => 'required|string|min:6|max:255',
      'phone' => 'required|string|max:255',
      're_password' => 'required|string|same:password'
  ];

  $messages = [
    're_password.same' => 'Mật khẩu và xác nhận mật khẩu phải giống nhau.',
];

$validator = Validator::make($request->all(), $rules, $messages);

    $credentials = $request->only('name','email', 'password','phone');
      $credentials['password'] = md5($credentials['password']);
      // $password = $request->input('password');
      // $re_password = $request->input('re_password');

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

    $rules = [
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|max:255',
  ];

  $validator = Validator::make($request->all(), $rules);

   // Check if validation fails
   if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput();
}  

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
    return view('user.index');
  }

public function load_books_by_type($type){

$booksQuery = Book::select('id', DB::raw("CONCAT(SUBSTRING(book_title, 1, 30), '...') as book_title")
,'book_price','book_image');

if($type == "gia_thap"){
  $booksQuery->orderBy('book_price','asc');
} else if($type == "gia_cao"){
  $booksQuery->orderBy('book_price','desc');
} else if($type == "ban_chay"){
  $booksQuery->join('tbl_order_details', 'tbl_order_details.product_id', '=', 'books.id')
->join('tbl_order', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
->select(DB::raw('sum(product_sales_quantity) as quantity'), 'books.id',  DB::raw("CONCAT(SUBSTRING(product_name, 1, 30), '...') as book_title"), 'book_image', 'book_price')
->where('order_status', '=', 'Đã giao hàng')
->orderBy('quantity', 'desc')
->groupBy('books.id', 'product_name', 'book_image', 'book_price');
} 
else {
  $booksQuery->orderBy('id','desc');
}

$books = $booksQuery->paginate(12);

    $ratings = Comment::select(DB::raw('avg(comment_rating) as rating'), 'book_id')
        ->groupBy('book_id')
        ->whereIn('book_id', $books->pluck('id'))
        ->get();

  return response()->json(['books' => $books, 'ratings' => $ratings]);
}


     public function book_details($id){
        $other_books = Book::inRandomOrder()->where('id','!=',$id)->limit(4)->get();
          $bookdetail = Book::find($id);
          $comments=Comment::where('book_id','=',$id)
          ->join('tbl_user', 'tbl_comment.user_id', '=', 'tbl_user.id')
          ->orderBy('comment_id','desc')->select('comment_content', 'comment_rating', 'comment_date', 'name')
          ->get();
          $reply_comment=DB::table('tbl_reply_comment')->get();
          $users = User::select('id','name')->get();

          return view('user.book_details',compact('bookdetail','other_books','comments','reply_comment','users'));
     }

     public function search_index(){
      return view('user.search');
     }


public function search_books($book_title)
{
    $books = Book::select('id', DB::raw('CONCAT(SUBSTRING(book_title, 1, 50), "...") as book_title'),
        'book_price', 'book_image')->where('book_title', 'LIKE', "%{$book_title}%")->get();
    
    $booksArray = $books->map(function ($book) {
        return [
            'id' => $book->id,
            'book_title' => $book->book_title,
            'url' => url("chitietsach/{$book->id}"),
        ];
    });

    return response()->json(['books' => $booksArray]);
}


 
}