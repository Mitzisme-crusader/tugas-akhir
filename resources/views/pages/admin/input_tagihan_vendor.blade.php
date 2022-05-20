@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/make_document_SPK.css') }}">
@endsection

@section('content')
<div class="content" style="width: 75%">
    <section>
        <?php $jenis_id_service_spk = 0 ?>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif

        @if($errors->any())
            <h4 class="message">terdapat field kosong</h4>
        @endif

        <h1>Input Tagihan Vendor</h1>
        <form action="{{ url('admin/proses_input_tagihan_vendor') }}" method="post">
            @csrf
            <h5 >Data Tagihan</h5>
            <div style="display:block;border:1px solid;width : 100%;height: 30px;">
                <select name="option_dokumen_SO" id="option_dokumen_SO" style="display:inline; width:100%">
                    <option value=""> Select Judul Dokumen SO</option>
                    @foreach ($list_dokumen_SO as $dokumen_SO)
                        <option>{{$dokumen_SO->nomor_so}}</option>
                    @endforeach
                </select>
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
                        <th>Vendor</th>
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
                <button type="submit" class="button"><span>Create Tagihan</span></button>
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
                console.log($id_jenis_service_spk);
                if($id_jenis_service_spk == 1){
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
                }
                else if($id_jenis_service_spk == 2){
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
                }
            });
        });
    </script>
</div>
@endsection
