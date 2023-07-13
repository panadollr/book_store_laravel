@include('user.layouts.header')

@php
$user = Session::get('user');
@endphp

<br>
<div class="ui container">
    <h2 class="ui center aligned header">Cài đặt tài khoản</h2>

   <div class="ui segment">
   <form class="ui form">
  <div class="field">
    <label>Tên tài khoản
    </label>
    <input type="text" name="name" value="{{$user->name}}" placeholder="{{$user->name}}">
  </div>
  <div class="field">
    <label>Email</label>
    <input disabled placeholder="{{$user->email}}" value="{{$user->email}}">
  </div>
  <div class="field">
  </div>
  <button class="ui button" type="submit">Cập nhật</button>
</form>
   </div>

</div>

<br><br><br><br>
@include('user.layouts.footer')