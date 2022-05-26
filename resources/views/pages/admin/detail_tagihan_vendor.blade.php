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
        <h1>Edit Dokumen SO</h1>
        <form action="{{ url('admin/proses_edit_dokumen_so') }}" style="width:100%" method="post">
            @csrf

            <h5 >Info Tagihan</h5>
            <div style="display:inline-block;border:1px solid;width : 48%;height: 200px;">
                <input type="hidden" value="{{$dokumen_so->nama_customer}}" name="input_nama_customer" id="input_nama_customer">
                <input type="hidden" value="{{$dokumen_so->alamat_customer}}" name="input_alamat_customer" id="input_alamat_customer">
                <div>
                    <textarea rows="3" cols="55" name="data_customer" id="input_data_customer" placeholder="Data Customer" readonly style="width: 100%">
                        {{$tagihan_vendor->total}}
                        {{$tagihan_vendor->hutang}}
                    </textarea>
                </div>
            </div>

            <h5 style="display: inline;position: absolute;top:84px">Data so</h5>
            <div style="display:inline;right:0px;border:1px solid;position: absolute;width:50%;height:200px;padding-left:30px;padding-top: 30px;right:18px">
                <div class="input-wrapper" style="width: 75%;margin-bottom:10px;">
                    <input type="Id_dokumen" name="Id_dokumen" id="Id_dokumen" readonly
                        value= {{$dokumen_so->nomor_so}}>
                    <label for="Id_dokumen" ><span> ID Dokumen SO</span></label>
                    <span class="error-message">{{ $errors->first('Id_dokumen') }}</span>
                </div>

                <div class="input-wrapper" style="width: 75%;margin-bottom:0px;">
                    <input type="date" name="tanggal_so" id="tanggal_so" placeholder="so Date" readonly
                        value="{{$dokumen_so->tanggal_so}}">
                    <span class="error-message">{{ $errors->first('tanggal_so') }}</span>
                </div>
            </div>

            <h5 style="background-color: var(--primary_color);color:var(--secondary_color)" id="tag_tabel_PPJK">Tabel Service PPJK</h5>
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
                        <th>Disc%</th>
                        <th>Tax</th>
                        <th>Amount</th>
                        <th>Nominal Pembayaran</th>
                        <th>Bank Pelunasan</th>
                        <th>Bank Tujuan Pembayaran</th>
                        <th>Active</th>
                    </thead>
                    <tbody id="tbody_tagihan_vendor">
                        <?php $nomor_urut_dokumen = 0 ?>
                        @foreach ($list_service_tagihan_vendor as $tagihan_vendor)
                        <tr>
                            <td>{{$nomor_urut_dokumen + 1}}</td>
                            <td>
                                <input type="text" style = "width:200px;" name="input_nama_service" value="{{$tagihan_vendor->nama_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" name="input_quantity_service" value="{{$tagihan_vendor->quantity_service}}">
                            </td>
                            @if($tagihan_vendor->container_service != null)
                                <td>
                                    <input type="text" style = "width:40px;" readonly name="input_container_service" value="{{$tagihan_vendor->container_service}}">
                                </td>
                            @endif
                            <td>
                                <input type="text" style = "width:80px;" readonly name="input_harga_service" value="{{$tagihan_vendor->harga_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px" name="input_diskon_service" value="{{$tagihan_vendor->diskon_service}}">
                            </td>
                            <td>
                                <input type="hidden" name="input_pajak_service" value="{{$tagihan_vendor->pajak_service}}"><input type="checkbox" @if($tagihan_vendor->pajak_service != 0) checked @endif style = "width:40px" nomor_urut= "${nomor_urut_dokumen}" onchange="ubah_total(this)" onclick="this.previousSibling.value=11-this.previousSibling.value">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_total" value = "{{$tagihan_vendor->total_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="nominal_pembayaran" value = 0>
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_bank_pelunasan" value = "{{$tagihan_vendor->total_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_bank_tujuan_pembayaran" value = "{{$tagihan_vendor->total_service}}">
                            </td>
                            <td>
                                <form action="{{url('admin/bayar_tagihan_vendor')}}" method="get">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id_relasi_tagihan_vendor_extra_service" value="{{$tagihan_vendor->id_relasi_tagihan_vendor_extra_service}}">
                                    <button type="submit" class="button"><span>Bayar</span></button>
                                </form>
                            </td>
                        </tr>
                        <?php $nomor_urut_dokumen++?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

    </section>
    <script>
        $(document).ready(function () {
        });
    </script>
</div>
@endsection
