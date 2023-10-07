<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//BookController
Route::get('/', [BookController::class, 'index']);
Route::get('/dangnhap', [BookController::class, 'login_index'])->name("login");
Route::post('/xacthucdangnhap', [BookController::class, 'login_authentication']);
Route::get('/dangky', [BookController::class, 'register_index']);
Route::post('/xacthucdangky', [BookController::class, 'register_authentication']);
Route::get('/load_books_by_type/{type}', [BookController::class,'load_books_by_type']);
Route::get('/chitietsach/{id}', [BookController::class, 'book_details']);
Route::get('/timkiem/{book_title}', [BookController::class,'search_books']);
Route::post('/giatien', [BookController::class,'giatien']);

//UserController
Route::middleware('user')->group(function () {
Route::get('/dangxuat', [UserController::class,'logout']);
Route::get('/checkout', [UserController::class,'checkout']);
Route::post('/tienhanhthanhtoan', [UserController::class,'save_checkout']);
Route::post('/dangbinhluan', [UserController::class,'post_comment']);
Route::get('/donhang', [UserController::class, 'user_order']);
Route::get('/get_user_orders_by_status={status}', [UserController::class, 'get_user_orders']);
Route::get('/xoadonhang/{payment_id}', [UserController::class, 'delete_user_order']);
Route::get('/cai_dat_tai_khoan', [UserController::class, 'account_settings_index']);
});

//AdminController
Route::prefix('admin')->group(function () {
    Route::get('',[AdminController::class, 'loginindex']);
    Route::post('xac_thuc_dang_nhap',[AdminController::class, 'login_authentication']);
    Route::get('tong_quan',[AdminController::class, 'index']);
    Route::get('publishers', [AdminController::class,'publishers']);
    Route::get('books', [AdminController::class,'books']);
    Route::get('orders',[AdminController::class,'orders']);
    Route::get('comments', [AdminController::class,'comments']);
    Route::get('logout',[AdminController::class, 'logout']);
});


// Route::get('/admin',[AdminController::class, 'loginindex']);
// Route::get('/admin_logout',[AdminController::class, 'logout']);
// Route::get('/tongquan',[AdminController::class, 'showdashboard']);
// Route::post('/admin_dashboard',[AdminController::class, 'dashboard']);
// Route::get('/show_table.1', [AdminController::class,'show_table']);
// Route::get('/show_publishers', [AdminController::class,'show_publishers']);
// Route::post('/timkiem_nxb_ajax', [AdminController::class,'timkiem_nxb_ajax'])->name('timkiem_nxb_ajax');
// Route::post('/timkiem_sach_ajax', [AdminController::class,'timkiem_sach_ajax'])->name('timkiem_sach_ajax');
// Route::get('/edit_nxb_ajax', [AdminController::class,'edit_nxb_ajax']);
// Route::get('/edit_sach_ajax', [AdminController::class,'edit_sach_ajax']);
// Route::get('/xembinhluan', [AdminController::class,'view_comment']);
// Route::post('/traloiphanhoi/{contact_id}', [AdminController::class,'answer_contact']);
// Route::post('/traloibinhluan', [AdminController::class,'reply_comment']);
// Route::get('/duyetbinhluan/{comment_id}', [AdminController::class,'check_comment']);
// Route::get('/xoabinhluan/{comment_id}', [AdminController::class,'delete_comment']);
// Route::get('/boduyetbinhluan/{comment_id}',[AdminController::class,'uncheck_comment']);
// Route::get('/order',[AdminController::class,'order_manager']);
// Route::get('/detail_order_ajax', [AdminController::class,'detail_order_ajax']);
// Route::get('/delete_order/{order_id}', [AdminController::class,'delete_order']);
// Route::get('/check_order/{order_id}', [AdminController::class,'check_order']);
// Route::get('/delivery_order/{order_id}',[AdminController::class,'delivery_order']);
// Route::get('/complete_order/{order_id}', [AdminController::class,'complete_order']);
// Route::get('/add_book', [AdminController::class,'add_book']);
// Route::post('/add_publisher',[AdminController::class,'add_publisher']);
// Route::post('/update_publisher/{publisher_id}',[AdminController::class,'update_publisher']);
// Route::post('/save_book', [AdminController::class,'save_book']);
// Route::get('/delete_book_table1/{book_id}', [AdminController::class,'delete_book_table1']);
// Route::get('/delete_publisher/{publisher_id}', [AdminController::class,'delete_publisher']);
// Route::post('/update_book/{book_id}', [AdminController::class,'update_book']);
// Route::get('/thongke', [AdminController::class,'orderByDay']);
// Route::get('/xoaphanhoi/{comment_id}', [AdminController::class,'delete_reply_comment']);

//CartController
Route::get('giohang', [CartController::class, 'show_cart']);
Route::post('add_to_cart', [CartController::class,'add_to_cart']);
Route::post('update_cart_quantity', [CartController::class,'update_cart_quantity']);
Route::post('delete_all_carts', [CartController::class,'delete_all_carts']);


