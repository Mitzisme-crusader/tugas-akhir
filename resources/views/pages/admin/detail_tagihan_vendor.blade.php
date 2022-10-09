@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/make_document_SPK.css') }}">
@endsection

@section('content')
<div class="content tagihan_vendor">
    <section>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/bayar_tagihan_vendor') }}" style="width:100%;::after" method="post">
            <div>
                <div style="display: inline-block;width:50%;">
                    <h1>Detail Tagihan Vendor</h1>
                </div>

                <div style="display: inline-block;width:50%;height: 100%;float:right;;text-align: center">
                    <div style="height: 10%; border: none">
                        <h5 style="border-width: 0px;margin-bottom :20px;margin-top:0px"> Info rekening</h5>
                    </div>
                    <div class="input-wrapper" style="width: 40%;margin-bottom:0px; display:inline-block">
                        <select style="width:100%" name="nomor_COA" class = "select_nomor_COA" id="select_nomor_COA" placeholder="nomor_COA">
                            <option value="">Select Nomor COA</option>
                            @for ($i = 0; $i<count($list_nomor_COA); ++$i)
                                <option value ="{{$list_nomor_COA[$i]->nomor_COA}}"> {{$list_nomor_COA[$i]->nomor_COA}}-{{$list_nomor_COA[$i]->nama_jenis_COA}} </option>
                            @endfor
                        </select>
                        <span class="error-message">{{ $errors->first('nomor_COA') }}</span>
                    </div>
                    <div class="input-wrapper" style="width: 40%;margin-bottom:0px; display:inline-block">
                        <select style="width:100%" name="nomor_rekening" class = "select_nomor_rekening" id="select_nomor_rekening" placeholder="nomor_rekening">
                            <option value="">Select Nomor Rekening</option>
                        </select>
                        <span class="error-message">{{ $errors->first('nomor_rekening') }}</span>
                    </div>
                </div>
            </div>
            @csrf
            <div>
                <h5 style="display: inline-block;width:50%">Info Tagihan</h5>

                <h5 style="display: inline-block;left : 200px">Data so</h5>
            </div>
            <div style="display:inline-block;border:1px solid;width : 48%;height: 200px;padding-left:50px;padding-top: 10px;right:18px">
                <input type="hidden" value="{{$dokumen_so->nama_customer}}" name="input_nama_customer" id="input_nama_customer">
                <input type="hidden" value="{{$dokumen_so->alamat_customer}}" name="input_alamat_customer" id="input_alamat_customer">
                <div>
                    <div class="input-wrapper" style = "width:75%;background-color: white;margin-bottom:0px;" >
                        <input type="text" name="input_total_tagihan" value="{{$tagihan_vendor->total_service}}">
                        <label for="input_total_tagihan" ><span> Total Service</span></label>
                        <span class="error-message">{{ $errors->first('input_total_tagihan') }}</span>
                    </div>

                    <div class="input-wrapper" style = "width:75%;background-color: white;margin-bottom:0px;" >
                        <input type="text" name="input_hutang_tagihan" value="{{$tagihan_vendor->hutang}}">
                        <label for="input_hutang_tagihan" ><span> Hutang Service</span></label>
                        <span class="error-message">{{ $errors->first('input_hutang_tagihan') }}</span>
                    </div>

                    <div class="input-wrapper" style = "width:75%;background-color: white;margin-bottom:0px;" >
                        <input type="text"  name="input_nominal_pembayaran" value="{{$tagihan_vendor->quantity_service}}">
                        <label for="input_nominal_pembayaran" ><span> Nominal Pembayaran</span></label>
                        <span class="error-message">{{ $errors->first('input_nominal_pembayaran') }}</span>
                    </div>

                </div>
            </div>


            <div style="display:inline;right:0px;border:1px solid;position: absolute;width:50%;height:200px;padding-left:100px;padding-top: 10px;right:18px">
                <div class="input-wrapper" style="width: 75%;margin-bottom:0px;">
                    <input type="Id_dokumen" name="Id_dokumen" id="Id_dokumen" readonly
                        value= {{$dokumen_so->nomor_so}}>
                    <label for="Id_dokumen" ><span> ID Dokumen SO</span></label>
                    <span class="error-message">{{ $errors->first('Id_dokumen') }}</span>
                </div>

                <div class="input-wrapper" style="width: 75%;margin-bottom:0px;">
                    <input type="Id_dokumen" name="Id_dokumen" id="Id_dokumen" readonly
                        value= {{$id_tagihan_vendor}}>
                    <label for="Id_dokumen" ><span> ID Tagihan Vendor</span></label>
                    <span class="error-message">{{ $errors->first('Id_dokumen') }}</span>
                </div>

                <div class="input-wrapper" style="width: 75%;margin-bottom:0px;">
                    <input type="date" name="tanggal_so" id="tanggal_so" placeholder="so Date" readonly
                        value="{{$dokumen_so->tanggal_so}}">
                    <span class="error-message">{{ $errors->first('tanggal_so') }}</span>
                </div>
            </div>

            <h5 style="background-color: var(--primary_color);color:var(--secondary_color)" id="tag_tabel_PPJK">Tabel Service</h5>
            <div class="table-wrapper"  style="width: 100%;margin-top: 15px">
                <table style="width: 100%">
                    <thead id="thead_tagihan_vendor">
                        <th>Item</th>
                        <th>Description</th>
                        <th>QTY</th>
                        @if(count($list_service_tagihan_vendor) > 0)
                            @if($list_service_tagihan_vendor[0]->container_service != null)
                                <th>container</th>
                            @endif
                        @endif
                        <th>Unit Price</th>
                        <th>Disc</th>
                        <th>Tax</th>
                        <th>Amount</th>
                    </thead>
                    <tbody id="tbody_tagihan_vendor">
                        <?php $nomor_urut_dokumen = 0 ?>
                        @foreach ($list_service_tagihan_vendor as $tagihan_vendor)
                        <tr>
                            <td>{{$nomor_urut_dokumen + 1}}</td>
                            <td>
                                <input type="text" style = "width:200px;" readonly name="input_nama_service" value="{{$tagihan_vendor->nama_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" readonly name="input_quantity_service" value="{{$tagihan_vendor->quantity_service}}">
                            </td>
                            @if($tagihan_vendor->container_service != null)
                                <td>
                                    <input type="text" style = "width:40px;" readonly name="input_container_service" value="{{$tagihan_vendor->container_service}}">
                                </td>
                            @endif
                            <td>
                                <input type="text" style = "width:100px;" readonly name="input_harga_service" value="{{$tagihan_vendor->harga_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:100px" name="input_diskon_service" value="{{$tagihan_vendor->diskon_service}}">
                            </td>
                            <td>
                                <input type="hidden" name="input_pajak_service" value="{{$tagihan_vendor->pajak_service}}"><input type="checkbox" @if($tagihan_vendor->pajak_service != 0) checked @endif style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onchange="ubah_total(this)" onclick="this.previousSibling.value=11-this.previousSibling.value">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" readonly name="input_total" value = "{{$tagihan_vendor->total_service}}">
                            </td>
                            {{-- <td>
                                <input type="text" style = "width:80px" name="nominal_pembayaran" value = 0>
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_bank_pelunasan" value = " ">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_bank_tujuan_pembayaran" value = " ">
                            </td> --}}
                        </tr>
                        <?php $nomor_urut_dokumen++?>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="container_right">
                <button type="submit" class="button" style="top: 10px;float:right"><span>Bayar</span></button>
            </div>
        </form>

    </section>
    <script>
        $(document).ready(function () {
            $("#select_nomor_COA").change(function() {
                let nomor_COA = $('#select_nomor_COA option:selected').val();
                $("#select_nomor_COA option[value='']").remove();
                $("#select_nomor_rekening").empty();

                $.ajax({
                    type : 'GET',
                    url: "{{ url('admin/get_data_rekening') }}"+'/?nomor_COA='+nomor_COA,
                    data: '',
                    success: function(data){
                        console.log(data);

                        for(let i = 0; i<data['list_rekening'].length; ++i){
                            console.log(data['list_rekening'][i]['nama_rekening'])
                            if(data['list_rekening'][i]['nama_rekening'] == null){
                                $('#select_nomor_rekening').append(new Option(data['list_rekening'][i]['nomor_rekening'], data['list_rekening'][i]['nomor_rekening']))
                            }
                            else{
                                $('#select_nomor_rekening').append(new Option(data['list_rekening'][i]['nama_rekening'] +"-"+ data['list_rekening'][i]['nomor_rekening'], data['list_rekening'][i]['nomor_rekening']))
                            }
                        }
                    }
                });
            });
        });
    </script>
</div>
@endsection
