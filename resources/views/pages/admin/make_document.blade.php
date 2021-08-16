@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/make_document_SPK.css') }}">
@endsection

@section('content')
<div class="content">
    <section>
        <h1>Create SPK</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_save_document') }}" method="post">
            @csrf
            <div class="input-wrapper">
                <select name="list_id_customer" class = "select_id_customer">
                    <option value="0">Select Customer's company</option>
                    @for ($i = 0; $i<count($list_customer['nama_perusahaan_customer']); ++$i)
                        <option value ="{{$list_customer['id_customer'][$i]->id_customer}}"> {{$list_customer['nama_perusahaan_customer'][$i]->nama_perusahaan_customer}} </option>
                    @endfor
                </select>
            </div>

            <div class="input-wrapper">
                <select name="list_id_service" class="select_id_service">
                    <option value="0">Select service</option>
                    @for ($i = 0; $i<count($list_service['nama_service']); ++$i)
                        <option value ="{{$list_service['id_service'][$i]->id_service}}"> {{$list_service['nama_service'][$i]->nama_service}} </option>
                    @endfor
                </select>
            </div>

            <div class="input-wrapper">
                <select name="list_container" class="select_container">
                    <option value="0">Select Container</option>
                    <option value="1">1x20'' && 1x40''</option>
                    <option value="2">1x20'' && 1x40'' && 1x45''</option>
                </select>
            </div>

            <div class="input-wrapper">
                <input type="text" name="port_customer" id="port_customer"
                    value="{{old('port_customer')}}">
                <label for="port_customer"><span> Port</span></label>
                <span class="error-message">{{ $errors->first('port_customer') }}</span>
            </div>

            <div>
                <legend>conveyance</legend>
                <div class = "jenis_pengangkutan_radio">
                    <input type="radio" name="jenis_angkutan" value="export">
                    <label for="jenis_angkutan"><span>Export</span></label>
                    <input type="radio" name="jenis_angkutan" value="import">
                    <label for="jenis_angkutan"><span>Import</span></label>
                </div>
            </div>

            <div>
                <legend>Shipment</legend>
                <div class = "jenis_pengiriman_radio">
                </div>
            </div>

            <div class = "jenis_pekerjaan_radio">
            </div>

            <button type="submit" class="button"><span>Create Document</span></button>
        </form>
    </section>
</div>
@endsection
