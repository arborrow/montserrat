@extends('template')
@section('content')
<!-- resources/views/auth/login.blade.php -->
<div class="jumbotron text-center">
<form method="POST" action="/auth/login">
    <div class="panel panel-default">
        {!! csrf_field() !!}
        <div class='panel-heading'>Login</div>
        <div class="panel-body">
            <div>Email: <input type="email" name="email" value="{{ old('email') }}"></div>
            <div>Password: <input type="password" name="password" id="password"></div>
            <div><input type="checkbox" name="remember"> Remember Me </div>
            <div><button type="submit">Login</button></div>
        </div>
    </div>
</form>
</div>
@stop