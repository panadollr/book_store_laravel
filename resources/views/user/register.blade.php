@include('user.layouts.header')

<div class="ui container">

<form class="ui large form" style="padding:70px" method="POST" action="{{url('xacthucdangky')}}">
@csrf
  <h1 class="ui dividing header">Đăng ký</h1>
  <div class="field">
  <label>Tên tài khoản</label>
        <input type="text" name="name" required/>
      </div>
      <div class="field">
    <label>Email</label>
        <input type="email" name="email" required/>
      </div>
      <div class="field">
      <label>Số điện thoại</label>
        <input type="text" name="phone" required/>
      </div>
      <div class="field">
    <label>Mật khẩu</label>
        <input type="password" name="password" required/>
      </div>
      <div class="field">
      <label>Nhập lại mật khẩu</label>
        <input type="password" name="re_password" required/>
      </div>
 <center> <button class="ui large blue button" >Đăng ký</button> 
 <a href="{{url('dangnhap')}}">Đăng nhập tại đây</a>
</center>
</form>
</div>


@include('user.layouts.footer')