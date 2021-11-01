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
        <h1>Create Dokumen SO</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_save_document') }}" method="post">
            @csrf

            <h5 >Pelanggan</h5>
            <div style="display:inline-block;border:3px solid;width : 50%;height: 90px">
                <select name="option_dokumen_SPK" id="option_dokumen_SPK" style="display:inline; width:100%">
                    <option value=""> Select Judul Dokumen</option>
                    @foreach ($list_dokumen_SPK as $dokumen_SPK)
                        <option>{{$dokumen_SPK->judul_dokumen}}</option>
                    @endforeach
                </select>

                <div>
                    <textarea rows="3" cols="55" name="data_customer" id="input_data_customer" placeholder="Data Customer" disabled style="width: 100%">
                    </textarea>
                </div>
            </div>

            <h5 style="display: inline;position: absolute;top:84px">Data SO</h5>
            <div style="display:inline;right:0px;border:3px solid;position: absolute;width:50%;height:90px">
                <div class="input-wrapper" style="width: 100%;margin-bottom:0px;">
                    <input type="Id_dokumen" name="Id_dokumen" id="Id_dokumen"
                        value= {{$nomor_dokumen_so}}>
                    <label for="Id_dokumen" ><span> ID Dokumen SO</span></label>
                    <span class="error-message">{{ $errors->first('Id_dokumen') }}</span>
                </div>

                <div class="input-wrapper" style="width: 100%;margin-bottom:0px;">
                    <input type="date" name="ETA" id="ETA" placeholder="SO Date"
                        value="<?php echo date('Y-m-d'); ?>">
                    <span class="error-message">{{ $errors->first('ETA') }}</span>
                </div>
            </div>

            <div class = "btn_submit_spk">
                <button type="submit" class="button"><span>Create Document</span></button>
            </div>

        </form>
    </section>
    <script>
        $(document).ready(function () {
            $("#option_dokumen_SPK").change(function() {
                $("#option_dokumen_SPK option[value='']").remove();
                let judul_dokumen = $('#option_dokumen_SPK option:selected').val();

                $.ajax({
                    type : 'GET',
                    url: "{{ url('admin/get_data_customer') }}"+'/?judul_dokumen='+judul_dokumen,
                    data: '',
                    success: function(data){
                        console.log(data['nama']+data['alamat']+data['provinsi']+data['negara']);
                        $("#input_data_customer").html(data['nama'] +'- '+ data['alamat'] + '- ' + data['provinsi'] + '- ' + data['negara']);
                        $("#input_data_customer").addClass("not-empty");
                    }
                });
            });
        });
    </script>
</div>
@endsection
