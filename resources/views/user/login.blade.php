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
<form class="ui large form" method="POST" action="{{url('xacthucdangnhap')}}">

@csrf
  <h1 class="ui dividing header">Đăng nhập</h1>
  <div class="field">
    <label>Email</label>
        <input type="email" name="email" required/>
      </div>
      <div class="field">
    <label>Mật khẩu</label>
        <input type="password" name="password" required/>
      </div>
 <center> <button class="ui large blue button" >Đăng nhập</button>
<a href="{{url('dangky')}}">Chưa có tài khoản ?</a>
</center>
</form>
</div>
</center>


@include('user.layouts.footer')

@if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
      errorAlert("{{ $error }}")
    </script>
    @endforeach
@endif