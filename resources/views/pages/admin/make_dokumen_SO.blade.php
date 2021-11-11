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
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif

        @if($errors->any())
            <h4 class="message">terdapat field kosong</h4>
        @endif

        <h1>Create Dokumen SO</h1>
        <form action="{{ url('admin/proses_add_dokumen_so') }}" method="post">
            @csrf
            <h5 >Pelanggan</h5>
            <div style="display:inline-block;border:1px solid;width : 48%;height: 200px;">
                <select name="option_dokumen_SPK" id="option_dokumen_SPK" style="display:inline; width:100%">
                    <option value=""> Select Judul Dokumen</option>
                    @foreach ($list_dokumen_SPK as $dokumen_SPK)
                        <option>{{$dokumen_SPK->judul_dokumen}}</option>
                    @endforeach
                </select>
                <input type="hidden" value="" name="input_nama_customer" id="input_nama_customer">
                <input type="hidden" value="" name="input_alamat_customer" id="input_alamat_customer">
                <div>
                    <textarea rows="3" cols="55" name="data_customer" id="input_data_customer" placeholder="Data Customer" readonly style="width: 100%">
                    </textarea>
                </div>
            </div>

            <h5 style="display: inline;position: absolute;top:84px">Data SO</h5>
            <div style="display:inline;right:0px;border:1px solid;position: absolute;width:50%;height:200px;padding-left:30px;padding-top: 30px;right:18px">
                <div class="input-wrapper" style="width: 75%;margin-bottom:10px;">
                    <input type="Id_dokumen" name="Id_dokumen" id="Id_dokumen"
                        value= {{$nomor_dokumen_so}}>
                    <label for="Id_dokumen" ><span> ID Dokumen SO</span></label>
                    <span class="error-message">{{ $errors->first('Id_dokumen') }}</span>
                </div>

                <div class="input-wrapper" style="width: 75%;margin-bottom:0px;">
                    <input type="date" name="tanggal_SO" id="tanggal_SO" placeholder="SO Date"
                        value="<?php echo date('Y-m-d'); ?>">
                    <span class="error-message">{{ $errors->first('tanggal_SO') }}</span>
                </div>
            </div>

            <div class="table-wrapper"  style="width: 100%;margin-top: 15px">
                <table style="width: 100%">
                    <thead id="thead_dokumen_SO">
                        <th>Item</th>
                        <th>Description</th>
                        <th>QTY</th>
                        <th>Unit Price</th>
                        <th>Disc%</th>
                        <th>Tax</th>
                        <th>Amount</th>
                        <th>Active</th>
                    </thead>
                    <tbody id="tbody_dokumen_SO">
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class = "btn_submit_spk" style="display: inline-block">
                <button type="submit" class="button"><span>Create Document</span></button>
            </div>
        </form>

        <div class = "btn_submit_spk" style="position: relative;bottom:69px;left:200px">
            <button  class="button" id="button_add_service"><span>Add New Service</span></button>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            $("select").select2();

            $("#button_add_service").click(function(){
                $("#tbody_dokumen_SO").append(`
                    <tr>
                        <td>${nomor_urut_dokumen + 1}</td>
                        <td>
                            <input type="text" style = "width:200px;" name="input_nama_service[]">
                        </td>
                        <td>
                            <input type="text" style = "width:40px;" name="input_quantity_service[]" value="1">
                        </td>
                        <td>
                            <input type="text" style = "width:40px;" name="input_container_service[]" value = "20">
                        </td>
                        <td>
                            <input type="text" style = "width:80px;" name="input_harga_service[]">
                        </td>
                        <td><input type="text" style = "width:40px" name="input_diskon_service[]" value = "0"></td>
                        <td><input type="text" style = "width:40px" name="input_pajak_service[]" value = "0"></td>
                        <td><input type="text" style = "width:80px" name="input_total[]" value = "0"></td>
                        <td>
                            <label>
                                <input type="checkbox" name="checkbox_status_service[]" value=${nomor_urut_dokumen} class="checkbox_status" checked>
                            </label>
                        </td>
                    </tr>
                    ${++nomor_urut_dokumen}
                `);
            });

            $("#option_dokumen_SPK").change(function() {
                $("#option_dokumen_SPK option[value='']").remove();
                let judul_dokumen = $('#option_dokumen_SPK option:selected').val();

                $.ajax({
                    type : 'GET',
                    url: "{{ url('admin/get_data_customer') }}"+'/?judul_dokumen='+judul_dokumen,
                    data: '',
                    success: function(data){
                        console.log(data);
                        console.log(data['list_extra_service'].length);
                        var banyak_extra_service = data['list_extra_service'].length;
                        $("#input_nama_customer").val(data['customer']['nama_customer']);
                        $("#input_alamat_customer").val(data['customer']['alamat_customer'] + '- ' + data['customer']['provinsi_customer'] + '- ' + data['customer']['negara_customer']);
                        $("#input_data_customer").html(data['customer']['nama_customer'] +'- '+ data['customer']['alamat_customer'] + '- ' + data['customer']['provinsi_customer'] + '- ' + data['customer']['negara_customer']);
                        $("#tbody_dokumen_SO").empty();
                        $("#thead_dokumen_SO").empty();
                        if(data['dokumen_spk']['id_service'] == 1){
                            $("#thead_dokumen_SO").append(`
                                <th>Item</th>
                                <th>Description</th>
                                <th>QTY</th>
                                <th>Container</th>
                                <th>Unit Price</th>
                                <th>Disc%</th>
                                <th>Tax</th>
                                <th>Amount</th>
                                <th>Active</th>
                            `);


                            for(nomor_urut_dokumen = 0; nomor_urut_dokumen < data['list_extra_service'].length; ++nomor_urut_dokumen){
                                $("#tbody_dokumen_SO").append(`
                                    <tr>
                                        <td>${nomor_urut_dokumen + 1}</td>
                                        <td>
                                            <input type="text" style = "width:200px;"  readonly name="input_nama_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['nama_extra_service']}">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:40px;" name="input_quantity_service[]" value = "1">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:40px;" readonly name="input_container_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['container']}">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:80px;" readonly name="input_harga_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['harga_extra_service']}">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:40px" value="0" name="input_diskon_service[]">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:40px" value="0" name="input_pajak_service[]">
                                        </td>
                                        <td>
                                            <input type="text" style = "width:80px" name="input_total[]" value = "${data['list_extra_service'][nomor_urut_dokumen]['harga_extra_service']}">
                                        </td>
                                        <td>
                                            <label>
                                                <input type="checkbox" name="checkbox_status_service[]" value=${nomor_urut_dokumen} class="checkbox_status" checked>
                                            </label>
                                        </td>
                                    </tr>
                                `);
                            }
                        }
                        else{

                        }


                    }
                });
            });
        });
    </script>
</div>
@endsection
