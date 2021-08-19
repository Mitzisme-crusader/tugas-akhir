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
                <select name="list_id_customer" class = "select_id" id="select_id_customer">
                    <option value="">Select Customer's company</option>
                    @for ($i = 0; $i<count($list_customer['nama_perusahaan_customer']); ++$i)
                        <option value ="{{$list_customer['id_customer'][$i]->id_customer}}"> {{$list_customer['nama_perusahaan_customer'][$i]->nama_perusahaan_customer}} </option>
                    @endfor
                </select>
                <span class="error-message">{{ $errors->first('list_id_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <select name="list_id_service" class="select_id" id="select_id_service">
                    <option value="">Select service</option>
                    @for ($i = 0; $i<count($list_service['nama_service']); ++$i)
                        <option value ="{{$list_service['id_service'][$i]->id_service}}"> {{$list_service['nama_service'][$i]->nama_service}} </option>
                    @endfor
                </select>
                <span class="error-message">{{ $errors->first('list_id_service') }}</span>
            </div>

            <div class="input-wrapper">
                <select name="list_container" class="select_container" id="select_id_container">
                    <option value="">Select Container</option>
                    <option value="1">1x20'' && 1x40''</option>
                    <option value="2">1x20'' && 1x40'' && 1x45''</option>
                </select>
                <span class="error-message">{{ $errors->first('list_container') }}</span>
            </div>

            <div class="input-wrapper">
                <select name="list_id_port" class="select_id" id="select_id_port">
                    <option value="">Select port</option>
                    @for ($i = 0; $i<count($list_port['nama_port']); ++$i)
                        <option value ="{{$list_port['id_port'][$i]->id_port}}"> {{$list_port['nama_port'][$i]->nama_port}} </option>
                    @endfor
                </select>
                <span class="error-message">{{ $errors->first('list_id_port') }}</span>
            </div>

            <div class = "input_radio_wrapper">
                <legend>conveyance</legend>
                <div class = "jenis_pengangkutan_radio">
                    <input type="radio" id = "export" name="jenis_pengangkutan_radio" value="export">
                    <label class = "jenis_angkutan" for="jenis_angkutan" value="export"><span>Export</span></label>
                    <input type="radio" id="import" name="jenis_pengangkutan_radio" value="import">
                    <label class = "jenis_angkutan" for="jenis_angkutan" value="import"><span>Import</span></label>
                </div>
                <span class="error-message">{{ $errors->first('jenis_pengangkutan_radio') }}</span>
            </div>

            <div class = "input_radio_wrapper">
                <legend>Shipment</legend>
                <div class = "jenis_pengiriman_radio">
                </div>
                <span class="error-message">{{ $errors->first('jenis_pengiriman_radio') }}</span>
            </div>

            <div class="input_radio_wrapper">
                <legend>Service</legend>
                <div class = "jenis_pekerjaan_radio">
                </div>
                <span class="error-message">{{ $errors->first('jenis_pekerjaan_radio') }}</span>
            </div>

            <button type="submit" class="button"><span>Create Document</span></button>
        </form>
    </section>
</div>
@endsection
