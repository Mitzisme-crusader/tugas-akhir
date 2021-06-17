@extends('layout.user_layout')

@section('title')
    <title>List User</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-register-box">
        <h1>This is list</h1>
        @if (Session::has('message'))
        <h4>{{ Session::get('message') }}</h4>
        @endif
    </div>
</div>
    @foreach ($users as $user)
        <div ><span>{{$user->email}}</span></div>
    @endforeach
@endsection
