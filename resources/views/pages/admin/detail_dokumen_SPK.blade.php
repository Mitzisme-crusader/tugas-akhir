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
        <h1>Detail SPK</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/download_dokumen_SPK') }}" method="post">
            @csrf
            <div class="input-wrapper">
                <select name="list_id_customer" class = "select_id" id="select_id_customer" placeholder="Select Customer's company">
                    <option value="{{$dokumen_SPK->nama_customer}}">{{$dokumen_SPK->nama_customer}}</option>
                </select>
                <span class="error-message">{{ $errors->first('list_id_customer') }}</span>
            </div>

            <div class="input-wrapper">
                <select name="list_id_service" class="select_id" id="select_id_service">
                    @if($dokumen_SPK->id_service == 1)
                        <option value="PPJK">Customer Handling Export Import</option>
                    @else
                        <option value="Freight">International Freight</option>
                    @endif
                </select>
                <span class="error-message">{{ $errors->first('list_id_service') }}</span>
            </div>

            @if($dokumen_SPK->metode_pengiriman == null)
                <div class="input-wrapper">
                    <select name="list_container" class="select_id" id="select_id_container">
                        @if($dokumen_SPK->container == 2)
                            <option value="2">1x20'' && 1x40''</option>
                        @else
                            <option value="3">1x20'' && 1x40'' && 1x45''</option>
                        @endif
                    </select>
                    <span class="error-message">{{ $errors->first('list_container') }}</span>
                </div>
            @endif

            @if($dokumen_SPK->metode_pengiriman != null)
                <div class="input-wrapper">
                    <select name="list_metode_pengangkutan" class="select_id" id="select_shipment_method">
                        @if($dokumen_SPK->metode_pengiriman == 'air')
                            <option value="air">By Air</option>
                        @else
                            <option value="sea">By Sea</option>
                        @endif
                    </select>
                    <span class="error-message">{{ $errors->first('list_shipment_method') }}</span>
                </div>
            @endif

            <div class="input-wrapper">
                <select name="list_id_port" class="select_id" id="select_id_port">
                    <option value="{{$dokumen_SPK->nama_port}}">{{$dokumen_SPK->nama_port}}</option>
                </select>
                <span class="error-message">{{ $errors->first('list_id_port') }}</span>
            </div>

            @if($dokumen_SPK->metode_pengiriman != null)
                <div class="input-wrapper input_freight" style="display: block">
                    <input type="nama_customer" name="origin" id="origin"
                        placeholder="Origin">
                    <label for="nama_customer"><span>{{$dokumen_SPK->origin}}</span></label>
                    <span class="error-message">{{ $errors->first('origin') }}</span>
                </div>
                <div class="input-wrapper input_freight" style="display: block">
                    <input type="nama_customer" name="destination" id="destination"
                        placeholder="destination">
                    <label for="destination"><span>{{$dokumen_SPK->destination}}</span></label>
                    <span class="error-message">{{ $errors->first('destination') }}</span>
                </div>
            @endif

            <div class = "input_radio_wrapper">
                <legend>conveyance</legend>
                <div class = "jenis_pengangkutan_radio">
                    @if($array_data_SPK['pengangkutan'] == 'E')
                        <input type="radio" id = "export" name="jenis_pengangkutan_radio" value="export" checked>
                        <label class = "jenis_angkutan" for="jenis_angkutan" value="export" selected><span>Export</span></label>
                    @else
                        <input type="radio" id="import" name="jenis_pengangkutan_radio" value="import" checked>
                        <label class = "jenis_angkutan" for="jenis_angkutan" value="import" selected><span>Import</span></label>
                    @endif
                </div>
                <span class="error-message">{{ $errors->first('jenis_pengangkutan_radio') }}</span>
            </div>

            <div class = "input_radio_wrapper">
                <legend>Shipment</legend>
                <div class = "jenis_pengiriman_radio">
                    @if($array_data_SPK['shipment'] == 'F')
                        <input type="radio" id = "FCL" name="jenis_pengiriman_radio" value="FCL" checked>
                        <label class = "jenis_pengiriman" for="jenis_pengiriman" value="FCL"><span>FCL</span></label>
                    @else
                        <input type="radio" id = "LCL" name="jenis_pengiriman_radio" value="LCL" checked>
                        <label class = "jenis_pengiriman" for="jenis_pengiriman" value="LCL" selected><span>LCL</span></label>
                    @endif
                </div>
                <span class="error-message">{{ $errors->first('jenis_pengiriman_radio') }}</span>
            </div>

            <div class="input_radio_wrapper">
                <legend>Service</legend>
                <div class = "jenis_pekerjaan_radio">
                    @if($array_data_SPK['service'] == 'A')
                        <input type="radio" id = "Allin" name="jenis_service_radio" value="Allin" checked>
                        <label class = "jenis_service" for="jenis_service" value="Allin" selected><span>All In</span></label>
                    @elseif($array_data_SPK['service'] == 'G')
                        <input type="radio" id = "Grey" name="jenis_service_radio" value="Grey" checked>
                        <label class = "jenis_service" for="jenis_service" value="Grey" selected><span>Grey</span></label>
                    @else
                        <input type="radio" id = "common" name="jenis_service_radio" value="common" checked>
                        <label class = "jenis_service" for="jenis_service" value="common" selected><span>Common</span></label>
                    @endif
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

            <input type="hidden" name="judul_dokumen" id="hidden_judul_dokumen" value="{{$dokumen_SPK->judul_dokumen}}">

            @if($dokumen_SPK->metode_pengiriman == null)
                <div class="container_extra_service" id="container_extra_service_custom_handling" style="margin-bottom: 1em">
                    <legend>Extra Services</legend>
                        @foreach ($list_relasi_extra_service_SPK as $relasi)
                            <input type="checkbox" id = "{{$relasi->nama_extra_service}}" name="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" style="opacity: 0;position:absolute; left:9999px;" >
                            <label class = "jenis_service" for="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" selected><span>{{$relasi->nama_extra_service}} / {{$relasi->container}}""</span></label>
                        @endforeach
                </div>
            @endif

            @if($dokumen_SPK->metode_pengiriman != null)
                <div class="container_extra_service_freight" id="container_extra_service_freight_origin" style="display: block">
                    <legend>Extra Services Origin</legend>
                    @foreach ($list_relasi_extra_service_SPK_PPJK as $relasi)
                        <input type="checkbox" id = "{{$relasi->nama_extra_service}}" name="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" style="opacity: 0;position:absolute; left:9999px;" >
                        <label class = "jenis_service" for="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" selected><span>{{$relasi->nama_extra_service}}</span></label>
                    @endforeach
                </div>

                <div class="container_extra_service_freight" id="container_extra_service_freight_destination" style="display: block">
                    <legend>Extra Services Destination</legend>
                    @foreach ($list_relasi_extra_service_SPK_freight as $relasi)
                        <input type="checkbox" id = "{{$relasi->nama_extra_service}}" name="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" style="opacity: 0;position:absolute; left:9999px;" >
                        <label class = "jenis_service" for="{{$relasi->nama_extra_service}}" value="{{$relasi->nama_extra_service}}" selected><span>{{$relasi->nama_extra_service}}</span></label>
                    @endforeach
                </div>
            @endif

            <label class="label_extra_service  popupable" id="label_extra_service_common"><span>Add Extra Service</span></label>

            <label class="label_extra_service popupable_freight_origin" id="label_extra_service_freight_origin"><span>Add Services for origin</span></label>

            <label class="label_extra_service popupable_freight_destination" id="label_extra_service_freight_destination"><span>Add Services for Destination</span></label>

            <div class = "btn_submit_spk">
                <button type="submit" class="button"><span>Download Document</span></button>
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
