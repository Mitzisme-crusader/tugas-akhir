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
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif

        @php
            $data = "";
        @endphp
        @if($errors->any())
            <h4 class="message">terdapat field kosong</h4>
        @endif

        <h1>Input Tagihan Customer</h1>
        <form action="{{ url('admin/proses_input_tagihan_customer') }}" method="post">
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

            <h5 >Tabel Service</h5>
            <div class="table-wrapper"  style="width: 100%;margin-top: 15px">
                <table style="width: 100%">
                    <thead id="thead_tagihan_customer">
                        <th>Item</th>
                        <th>Description</th>
                        <th>QTY</th>
                        <th>Unit Price</th>
                        <th>Disc%</th>
                        <th>Tax</th>
                        <th>Amount</th>
                        <th>Active</th>
                    </thead>
                    <tbody id="tbody_tagihan_customer">
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class = "btn_submit_tagihan_customer" style="display: inline-block">
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
                    $("#tbody_tagihan_customer").append(`
                        <tr>
                            <td>${nomor_urut_dokumen + 1}</td>
                            <td>
                                <input type="text" style = "width:150px;" name="input_nama_service[]">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" id="input_quantity_PPJK_${nomor_urut_dokumen}" onkeyup=(ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_quantity_service[]" value="1">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" name="input_container_service[]" value = "20">
                            </td>
                            <td>
                                <input type="text" style = "width:80px;" id="input_harga_unit_PPJK_${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_harga_service[]">
                            </td>
                            <td><input type="text" style = "width:40px" id="input_diskon_PPJK_${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_diskon_service[]" value = "0"></td >
                            <td>
                                <input type="hidden" name="input_pajak_service[]" value="0"><input type="checkbox" style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onchange="ubah_total(this)" onclick="this.previousSibling.value=11-this.previousSibling.value">
                            </td>
                            <td>
                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                            </td>
                            <td><input type="text" style = "width:80px" id="input_total_PPJK_${nomor_urut_dokumen}" name="input_total[]" value = "0"></td>
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
                    $("#tbody_tagihan_customer").append(`
                        <tr>
                            <td>${nomor_urut_dokumen + 1}</td>
                            <td>
                                <input type="text" style = "width:150px;" name="input_nama_service[]">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" id="input_quantity_PPJK_${nomor_urut_dokumen}" onkeyup=(ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_quantity_service[]" value="1">
                            </td>
                            <td>
                                <input type="text" style = "width:80px;" id="input_harga_unit_PPJK_${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_harga_service[]">
                            </td>
                            <td><input type="text" style = "width:40px" id="input_diskon_PPJK_${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" name="input_diskon_service[]" value = "0"></td>
                            <td>
                                <input type="hidden" name="input_pajak_service[]" value="0"><input type="checkbox" checked style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onchange="ubah_total(this)" onclick="this.previousSibling.value=1-this.previousSibling.value">
                            </td>
                            <td>
                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                            </td>
                            <td><input type="text" style = "width:80px" id="input_total_PPJK_${nomor_urut_dokumen}" name="input_total[]" value = "0"></td>
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

            $("#option_dokumen_SO").change(function() {
                $("#option_dokumen_SO option[value='']").remove();
                $("#tbody_tagihan_customer").empty();
                $("#thead_tagihan_customer").empty();
                let nomor_so = $('#option_dokumen_SO option:selected').val();

                $.ajax({
                    type : 'GET',
                    url: "{{ url('admin/get_data_extra_service_SO') }}"+'/?nomor_so='+nomor_so,
                    data: '',
                    success: function(data){
                        console.log(data);
                        console.log(data['list_extra_service'].length);

                        $id_jenis_service_spk = data['dokumen_so']['id_service'];

                        if(data['list_extra_service'][0]['container_service'] != null){
                            $("#thead_tagihan_customer").append(`
                                <th>Item</th>
                                <th>Description</th>
                                <th>QTY</th>
                                <th>Container</th>
                                <th>Unit Price</th>
                                <th>Disc%</th>
                                <th>Tax</th>
                                <th>Keterangan</th>
                                <th>Amount</th>
                                <th>Active</th>
                            `);


                            for(nomor_urut_dokumen = 0; nomor_urut_dokumen < data['list_extra_service'].length; ++nomor_urut_dokumen){
                                if(data['list_extra_service'][nomor_urut_dokumen]['pajak_service'] != 0){
                                    $("#tbody_tagihan_customer").append(`
                                        <tr>
                                            <td>${nomor_urut_dokumen + 1}</td>
                                            <td>
                                                <input type="text" style = "width:150px;" name="input_nama_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['nama_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;" id="input_quantity_PPJK_${nomor_urut_dokumen}" name="input_quantity_service[]" onkeyup=(ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" value = "1">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;" name="input_container_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['container_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px;" id="input_harga_unit_PPJK_${nomor_urut_dokumen}" name="input_harga_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['harga_service']}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px" value="0" id="input_diskon_PPJK_${nomor_urut_dokumen}" name="input_diskon_service[]" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) value="${data['list_extra_service'][nomor_urut_dokumen]['diskon_service']}" nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="input_pajak_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['pajak_service']}"><input type="checkbox" checked style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) onclick="this.previousSibling.value=11-this.previousSibling.value">
                                            </td>
                                            <td>
                                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px" id="input_total_PPJK_${nomor_urut_dokumen}" name="input_total[]" value = "${data['list_extra_service'][nomor_urut_dokumen]['total_service']}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="checkbox_status_service[]" value=${nomor_urut_dokumen} class="checkbox_status" checked>
                                                </label>
                                            </td>
                                        </tr>
                                    `);
                                }
                                else{
                                    $("#tbody_tagihan_customer").append(`
                                        <tr>
                                            <td>${nomor_urut_dokumen + 1}</td>
                                            <td>
                                                <input type="text" style = "width:150px;" name="input_nama_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['nama_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;" id="input_quantity_PPJK_${nomor_urut_dokumen}" name="input_quantity_service[]" onkeyup=(ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" value = "1">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;"" name="input_container_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['container_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px;" id="input_harga_unit_PPJK_${nomor_urut_dokumen}" name="input_harga_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['harga_service']}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px" value="0" id="input_diskon_PPJK_${nomor_urut_dokumen}" name="input_diskon_service[]" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) value="${data['list_extra_service'][nomor_urut_dokumen]['diskon_service']}" nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="input_pajak_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['pajak_service']}"><input type="checkbox" style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onkeyup= (ubah_total_PPJK(${nomor_urut_dokumen})) onclick="this.previousSibling.value=11-this.previousSibling.value">
                                            </td>
                                            <td>
                                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px" id="input_total_PPJK_${nomor_urut_dokumen}" name="input_total[]" value = "${data['list_extra_service'][nomor_urut_dokumen]['total_service']}">
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
                        }
                        else{
                            $("#thead_tagihan_customer").append(`
                                <th>Item</th>
                                <th>Description</th>
                                <th>QTY</th>
                                <th>Unit Price</th>
                                <th>Disc%</th>
                                <th>Tax</th>
                                <th>Keterangan</th>
                                <th>Amount</th>
                                <th>Active</th>
                            `);


                            for(nomor_urut_dokumen = 0; nomor_urut_dokumen < data['list_extra_service'].length; ++nomor_urut_dokumen){
                                if(data['list_extra_service'][nomor_urut_dokumen]['pajak_service'] != 0){
                                    $("#tbody_tagihan_customer").append(`
                                        <tr>
                                            <td>${nomor_urut_dokumen + 1}</td>
                                            <td>
                                                <input type="text" style = "width:150px;" name="input_nama_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['nama_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;" id="input_quantity_freight_${nomor_urut_dokumen}" name="input_quantity_service[]" onkeyup=(ubah_total_freight(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" value = "1">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px;" id="input_harga_unit_freight_${nomor_urut_dokumen}" name="input_harga_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['harga_service']}" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px" value="0" id="input_diskon_freight_${nomor_urut_dokumen}" name="input_diskon_service[]" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) value="${data['list_extra_service'][nomor_urut_dokumen]['diskon_service']}" nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="input_pajak_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['pajak_service']}"><input type="checkbox" checked style ="width:40px" nomor_urut= "${nomor_urut_dokumen}" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) onclick="this.previousSibling.value=1.1-this.previousSibling.value">
                                            </td>
                                            <td>
                                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px" id="input_total_freight_${nomor_urut_dokumen}" name="input_total[]" value = "${data['list_extra_service'][nomor_urut_dokumen]['total_service']}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="checkbox_status_service[]" value=${nomor_urut_dokumen} class="checkbox_status" checked>
                                                </label>
                                            </td>
                                        </tr>
                                    `);
                                }
                                else{
                                    $("#tbody_tagihan_customer").append(`
                                        <tr>
                                            <td>${nomor_urut_dokumen + 1}</td>
                                            <td>
                                                <input type="text" style = "width:150px;" name="input_nama_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['nama_service']}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px;" id="input_quantity_freight_${nomor_urut_dokumen}" name="input_quantity_service[]" onkeyup=(ubah_total_freight(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}" value = "1">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px;" id="input_harga_unit_freight_${nomor_urut_dokumen}" name="input_harga_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['harga_service']}" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="text" style = "width:40px" value="0" id="input_diskon_freight_${nomor_urut_dokumen}" name="input_diskon_service[]" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) value="${data['list_extra_service'][nomor_urut_dokumen]['diskon_service']}" nomor_urut= "${nomor_urut_dokumen}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="input_pajak_service[]" value="${data['list_extra_service'][nomor_urut_dokumen]['pajak_service']}"><input type="checkbox" style ="width:40px" nomor_urut= "${nomor_urut_dokumen}" onkeyup= (ubah_total_freight(${nomor_urut_dokumen})) onclick="this.previousSibling.value=1.1-this.previousSibling.value">
                                            </td>
                                            <td>
                                                <textarea rows="3" cols="20" name="keterangan_tagihan[]" id="input_keterangan_tagihan" placeholder="Keterangan Tagihan" style="width: 100%"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" style = "width:80px" id="input_total_freight_${nomor_urut_dokumen}" name="input_total[]" value = "${data['list_extra_service'][nomor_urut_dokumen]['total_service']}">
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
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        function ubah_total_PPJK(nomor_urut_dokumen){
            $harga_unit = $("#input_harga_unit_PPJK_"+nomor_urut_dokumen).val();
            $quantity_unit = $("#input_quantity_PPJK_"+nomor_urut_dokumen).val();
            $diskon_unit = $("#input_diskon_PPJK_"+nomor_urut_dokumen).val();
            $("#input_total_PPJK_"+nomor_urut_dokumen).val($harga_unit * $quantity_unit - $diskon_unit);
        }
        function ubah_total_freight(nomor_urut_dokumen){
            $harga_unit = $("#input_harga_unit_freight_"+nomor_urut_dokumen).val();
            $quantity_unit = $("#input_quantity_freight_"+nomor_urut_dokumen).val();
            $diskon_unit = $("#input_diskon_freight_"+nomor_urut_dokumen).val();
            $("#input_total_freight_"+nomor_urut_dokumen).val($harga_unit * $quantity_unit - $diskon_unit);
        }
    </script>
</div>
@endsection
