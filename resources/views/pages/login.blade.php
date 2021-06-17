@extends('layout.user_layout')

@section('title')
    <title>Login</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-register-box">
        <h1>Welcome Back</h1>
        @if (Session::has('message'))
        <h4>{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('/proses_login') }}" method="post">
            @csrf
            <div class="input-wrapper">
                <input type="text" name="email" id="email" value="{{ old('email') }}">
                <label for="email"><span>E-mail</span></label>
                <span class="error-message">{{ $errors->first('email') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="password" name="password" id="password">
                <label for="password"><span>Password</span></label>
                <span class="error-message">{{ $errors->first('password') }}</span>
            </div>
            <button type="submit" class="button"><span>Login</span></button>
        </form>
    </div>
</div>
    @foreach ($users as $user)
        <div ><span>{{$user}}</span></div>
    @endforeach
@endsection
