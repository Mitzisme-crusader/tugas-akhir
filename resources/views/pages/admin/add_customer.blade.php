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
        <h1>Add New Customer</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_add_customer') }}" method="post">
            @csrf
            <div class="input-wrapper">
                <input type="nama_customer" name="nama_customer" id="nama_customer"
                    value="{{old('nama_customer')}}">
                <label for="nama_customer"><span>Nama Customer</span></label>
                <span class="error-message">{{ $errors->first('nama_customer') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="email_customer" name="email_customer" id="email_customer"
                    value="{{old('email_customer')}}">
                <label for="email_customer"><span> Email Customer</span></label>
                <span class="error-message">{{ $errors->first('email_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="npwp_customer" name="npwp_customer" id="npwp_customer"
                    value="{{old('npwp_customer')}}">
                <label for="npwp_customer"><span> npwp Customer</span></label>
                <span class="error-message">{{ $errors->first('npwp_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="alamat_pajak_customer" name="alamat_pajak_customer" id="alamat_pajak_customer"
                    value="{{old('alamat_pajak_customer')}}">
                <label for="email_customer"><span> Alamat Pajak Customer</span></label>
                <span class="error-message">{{ $errors->first('alamat_pajak_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="kode_pos_customer" name="kode_pos_customer" id="kode_pos_customer"
                    value="{{old('kode_pos_customer')}}">
                <label for="kode_pos_customer"><span> Kode Pos Customer</span></label>
                <span class="error-message">{{ $errors->first('kode_pos_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="negara_customer" name="negara_customer" id="negara_customer"
                    value="{{old('negara_customer')}}">
                <label for="negara_customer"><span> Negara Customer</span></label>
                <span class="error-message">{{ $errors->first('negara_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nomor_telepon_customer" name="nomor_telepon_customer" id="nomor_telepon_customer"
                    value="{{old('nomor_telepon_customer')}}">
                <label for="nomor_telepon_customer"><span> nomor telepon customer</span></label>
                <span class="error-message">{{ $errors->first('nomor_telepon_customer') }}</span>
            </div>

            <button type="submit" class="button"><span>Add Customer</span></button>
        </form>
    </section>
</div>
@endsection
