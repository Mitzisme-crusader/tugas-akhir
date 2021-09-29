@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="content">
    <section>
        <h1>Add New Service</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_add_service') }}" class = "form_add" method="post">
            @csrf
            <div class="input-wrapper">
                <input type="nama_service" name="nama_service" id="nama_service"
                    value="{{old('nama_service')}}">
                <label for="nama_service"><span>Nama Service</span></label>
                <span class="error-message">{{ $errors->first('nama_service') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="deskripsi_service" name="deskripsi_service" id="deskripsi_service"
                    value="{{old('deskripsi_service')}}">
                <label for="deskripsi_service"><span>Deskripsi Service</span></label>
                <span class="error-message">{{ $errors->first('deskripsi_service') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="biaya_service" name="biaya_service" id="biaya_service"
                    value="{{old('biaya_service')}}">
                <label for="biaya_service"><span> Biaya Service</span></label>
                <span class="error-message">{{ $errors->first('biaya_service') }}</span>
            </div>

            <button type="submit" class="button"><span>Add Service</span></button>
        </form>
    </section>
</div>
@endsection
