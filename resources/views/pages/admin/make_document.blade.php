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
                <select name="list_id_customer" class = "select_id" id="select_id_customer" placeholder="Select Customer's company">
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
                <select name="list_container" class="select_id" id="select_id_container">
                    <option value="">Select Container</option>
                    <option value="2">1x20'' && 1x40''</option>
                    <option value="3">1x20'' && 1x40'' && 1x45''</option>
                </select>
                <span class="error-message">{{ $errors->first('list_container') }}</span>
            </div>

            <div class="input-wrapper">
                <select name="list_metode_pengangkutan" class="select_id" id="select_shipment_method">
                    <option value="">Select Method of shipment</option>
                    <option value="air">By Air</option>
                    <option value="sea">By Sea</option>
                </select>
                <span class="error-message">{{ $errors->first('list_shipment_method') }}</span>
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

            <div class="input-wrapper input_freight">
                <input type="nama_customer" name="origin" id="origin"
                    placeholder="Origin">
                <label for="nama_customer"><span>Origin</span></label>
                <span class="error-message">{{ $errors->first('origin') }}</span>
            </div>
            <div class="input-wrapper input_freight">
                <input type="nama_customer" name="destination" id="destination"
                    placeholder="destination">
                <label for="destination"><span>Destination</span></label>
                <span class="error-message">{{ $errors->first('destination') }}</span>
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

            <div class="popup">
                <div class="popup-box">
                    <span><i class="fas fa-times-circle"></i></span>
                    <div class="popup-box-header">
                        <h2 style="padding-left: 6rem">Add Extra Service</h2>
                    </div>
                    <div class="popup-box-body">
                        <div class="input_wrapper" style="padding-left: 6rem;padding-top: 3rem">
                            <label class = "nama_extra_service" for="nama_extra_service" value="" style="display: block;margin-bottom: 15px"><span>Nama Extra Service : </span></label>
                            <input type="text" id="nama_extra_service" style="margin-bottom: 5px">
                        </div>
                        <div class="input_wrapper" style="padding-left: 6rem">
                            <div class="container_harga_extra_service">

                            </div>
                        </div>
                    </div>
                    <div class="popup-box-footer">
                        <button type="button" class="button button-add_extra_service"><span>Add</span></button>
                        <button type="button" class="button button-cancel"><span>Cancel</span></button>
                    </div>
                </div>
            </div>

            <div class="popup_freight">
                <div class="popup-box">
                    <span><i class="fas fa-times-circle"></i></span>
                    <div class="popup-box-header">
                        <h2 style="padding-left: 6rem">Add Extra Service Freight</h2>
                    </div>
                    <div class="popup-box-body">
                        <div class="input_wrapper" style="padding-left:6rem;padding-top:3rem">
                            <label for="nama_extra_service_freight" value="" style="display:block;font-weight: bold;width:100%;margin-bottom: 15px" ><span style="width:100%">Nama Extra Service : </span></label>
                            <input style="margin-bottom: 5px" type="text" id="nama_extra_service_freight">
                            <label for="harga_extra_service_freight" value=""style="display:block;font-weight: bold;width:100%;margin-bottom: 15px"><span style="width:100%">Harga Extra Service : </span></label>
                            <input style="margin-bottom: 5px" type="number" id="harga_extra_service_freight">
                        </div>
                    </div>
                    <div class="popup-box-footer">
                        <button type="button" class="button button-add_extra_service_freight" value=""><span>Add</span></button>
                        <button type="button" class="button button-cancel"><span>Cancel</span></button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="hidden_nama_extra_service" id="hidden_nama_extra_service">
            <input type="hidden" name="hidden_harga_20_feet_extra_service" id="hidden_harga_20_feet_extra_service">
            <input type="hidden" name="hidden_harga_40_feet_extra_service" id="hidden_harga_40_feet_extra_service">
            <input type="hidden" name="hidden_harga_45_feet_extra_service" id="hidden_harga_45_feet_extra_service">

            <input type="hidden" name="hidden_nama_extra_service_freight_origin" id="hidden_nama_service_freight_origin">
            <input type="hidden" name="hidden_harga_extra_service_freight_origin" id="hidden_harga_service_freight_origin">
            <input type="hidden" name="hidden_nama_extra_service_freight_destination" id="hidden_nama_service_freight_destination">
            <input type="hidden" name="hidden_harga_extra_service_freight_destination" id="hidden_harga_service_freight_destination">

            <div class="container_extra_service" id="container_extra_service_custom_handling" style="margin-bottom: 1em">
                <legend>Extra Services</legend>
            </div>

            <div class="container_extra_service_freight" id="container_extra_service_freight_origin">
                <legend>Extra Services Origin</legend>
            </div>

            <div class="container_extra_service_freight" id="container_extra_service_freight_destination">
                <legend>Extra Services Destination</legend>
            </div>

            <label class="label_extra_service  popupable" id="label_extra_service_common"><span>Add Extra Service</span></label>

            <label class="label_extra_service popupable_freight_origin" id="label_extra_service_freight_origin"><span>Add Service for origin</span></label>

            <label class="label_extra_service popupable_freight_destination" id="label_extra_service_freight_destination"><span>Add Services for Destination</span></label>

            <div class = "btn_submit_spk">
                <button type="submit" class="button" style="bottom:30px;float:right;display:block"><span>Create Document</span></button>
            </div>

        </form>
    </section>
</div>
<script>
    $(function() {
        $('select').selectize(options);
    });
</script>
@endsection
