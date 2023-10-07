@include('user.layouts.header')

<style>
  .login-all {
    padding: 50px;
  }
    .login.segment {
        max-width: 40%;
        border-radius: 25px;
        box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.2);
      }

  @media only screen and (max-width: 700px) {
    .login-all {
    padding: 10px;
  }
    .login.segment {
        max-width: 100%;
      }
    }
</style>

<center class="login-all">
<div class="ui login segment">
<form class="ui large form" method="POST" action="{{url('xacthucdangky')}}">
@csrf
  <h1 class="ui dividing header">Đăng ký</h1>
  <div class="field">
  <label>Tên tài khoản</label>
        <input type="text" name="name" >
      </div>
      <div class="field">
    <label>Email</label>
        <input type="email" name="email" >
      </div>
      <div class="field">
      <label>Số điện thoại</label>
        <input type="text" name="phone" >
      </div>
      <div class="field">
    <label>Mật khẩu</label>
        <input type="password" name="password" >
      </div>
      <div class="field">
      <label>Nhập lại mật khẩu</label>
        <input type="password" name="re_password" >
      </div>
 <center> <button class="ui large blue button" >Đăng ký</button> 
 <a href="{{url('dangnhap')}}">Đăng nhập tại đây</a>
</center>
</form>
</div>
</center>


@if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
      errorAlert("{{ $error }}")
    </script>
    @endforeach
@endif

@include('user.layouts.footer')