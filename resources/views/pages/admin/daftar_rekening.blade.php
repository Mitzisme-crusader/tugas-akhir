@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/daftar_rekening.css') }}">
@endsection

@section('content')
<div class="content">
    <section>
        <h1>Add New Rekening</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_add_rekening') }}" class = "form_add" method="post">
            @csrf

            <div class="input-wrapper" id="select_nomor_COA">
                <select name="option_nomor_COA" id="option_nomor_COA" style="display:inline; width:100%">
                    <option value=""> Select Nomor COA</option>
                    @foreach ($list_nomor_COA as $nomor_COA)
                        <option>{{$nomor_COA->nomor_COA}}</option>
                    @endforeach
                </select>
                <span class="error-message">{{ $errors->first('option_nomor_COA') }}</span>
            </div>

            <div class="input-wrapper class_nomor_COA">
                <input type="input_nomor_COA" name="input_nomor_COA" id="input_nomor_COA"
                    value="{{old('input_nomor_COA')}}">
                <label for="input_nomor_COA"><span>Nomor COA</span></label>
                <span class="error-message">{{ $errors->first('input_nomor_COA') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="input_nama_jenis_COA" name="input_nama_jenis_COA" id="input_nama_jenis_COA"
                    value="{{old('input_nama_jenis_COA')}}">
                <label for="input_nama_jenis_COA"><span>Nama jenis COA</span></label>
                <span class="error-message">{{ $errors->first('input_nama_jenis_COA')}}</span>
            </div>

            <div class="input-wrapper">
                <input type="input_total_COA" name="input_total_COA" id="input_total_COA"
                    value="{{old('input_total_COA')}}">
                <label for="input_total_COA"><span>Total COA</span></label>
                <span class="error-message">{{ $errors->first('input_total_COA') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="input_nama_rekening" name="input_nama_rekening" id="input_nama_rekening"
                    value="{{old('input_nama_rekening')}}">
                <label for="input_nama_rekening"><span>Nama Rekening</span></label>
                <span class="error-message">{{ $errors->first('input_nama_rekening') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="input_nomor_rekening" name="input_nomor_rekening" id="input_nomor_rekening"
                    value="{{old('input_nomor_rekening')}}">
                <label for="input_nomor_rekening"><span>Nomor Rekening</span></label>
                <span class="error-message">{{ $errors->first('input_nomor_rekening') }}</span>
            </div>

            <div>
                <input type="checkbox" id="input_new_COA" name="input_new_COA" value="">

                <label class="label_checkbox_new_COA" for="input_new_COA">Add New COA</label>

                <button type="submit" class="button add_new_rekening"><span>Add Rekening</span></button>
            </div>
        </form>
    </section>

    <script>
        $(document).ready(function () {
            $("select").select2();

            $("#input_new_COA").change(function(){
                if($("#input_new_COA").is(":checked")){
                    $("#select_nomor_COA").css("display","none");
                    $("#option_nomor_COA").val("").change();
                    $("#option_nomor_COA").val("");

                    $("#input_nama_jenis_COA").val("");
                    $("#input_total_COA").val("");
                    $('#input_nama_jenis_COA').removeClass("not-empty");
                    $('#input_total_COA').removeClass("not-empty");

                    $(".class_nomor_COA").css("display","block");
                }
                else{
                    $("#select_nomor_COA").css("display","block");

                    $("#input_nama_jenis_COA").val("");
                    $("#input_total_COA").val("");
                    $('#input_nama_jenis_COA').removeClass("not-empty");
                    $('#input_total_COA').removeClass("not-empty");

                    $(".class_nomor_COA").css("display","none");
                }
            });

            $("#option_nomor_COA").change(function() {

                let nomor_COA = $('#option_nomor_COA option:selected').val();

                $.ajax({
                    type : 'GET',
                    url: "{{ url('admin/get_data_COA') }}"+'/?nomor_COA='+nomor_COA,
                    data: '',
                    success: function(data){
                        console.log(data);

                        $("#input_nama_jenis_COA").val(data['nomor_COA']['nama_jenis_COA']);
                        $('#input_nama_jenis_COA').addClass("not-empty");
                        $("#input_total_COA").val(data['nomor_COA']['total_COA']);
                        $('#input_total_COA').addClass("not-empty");
                        // $("#input_total_COA").val(data['customer']['alamat_customer'] + '- ' + data['customer']['provinsi_customer'] + '- ' + data['customer']['negara_customer']);

                        // $id_jenis_service_spk = data['dokumen_spk']['id_service'];

                    }
                });
            });
        });
    </script>
</div>
@endsection
