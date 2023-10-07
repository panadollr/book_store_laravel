<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Session;

class CartController extends Controller
{
    public function show_cart(){
        //Session::put('cart', null);
        $carts = Session::get('cart');
          return view('user.cart', compact('carts'));          
     }


     public function add_to_cart(Request $request){
        $book_id = $request->book_id;
        $quantity = $request->quantity;
      $book = Book::where('id', $book_id)->first();
      $session_id = substr(md5(microtime()), rand(0,26), 5);
      
      $cart = Session::get('cart') ?? [];
      
      $is_available = false;
      foreach ($cart as $key => $item) {
          if ($item['book_id'] == $book_id) {
              $is_available = true;
              $cart[$key]['book_amount'] += $quantity;
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
              'book_amount' => $quantity,
          ];
      }
      
      Session::put('cart', $cart);
      return response()->json(['alert' => "Đã thêm vào giỏ hàng", 'cart_size' => count($cart)]);
  }
  
      public function update_cart_quantity(Request $request) {
        $book_id = $request->key;
        $quantity = $request->quantity;
    $carts = Session::get('cart', []);
    $cart = $carts[$book_id];
    
    if ($quantity == 0) {
      unset($carts[$book_id]);
      $cart = null;
    } else {
        $carts[$book_id]['book_amount'] = $quantity;
    }
    Session::put('cart', $carts);
   return response()->json(['alert' => "Đã cập nhật giỏ hàng", 'carts' => $carts, 'cart_size' => count($carts)]);
}

public function delete_all_carts(){
    Session::put('cart', null);
    $carts = Session::get('cart', []);
    return response()->json(['alert' => "Đã xóa tất cả trong giỏ hàng", 'carts' => $carts, 'cart_size' => count($carts)]);
}

}
