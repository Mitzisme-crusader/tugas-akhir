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
        <h1>Edit Dokumen SO</h1>
        <form action="{{ url('admin/proses_edit_dokumen_so') }}" method="post">
            @csrf

            <h5 >Pelanggan</h5>
            <div style="display:inline-block;border:1px solid;width : 48%;height: 200px;">
                <select name="option_dokumen_SPK" id="option_dokumen_SPK" style="display:inline; width:100%">
                    <option value="{{$dokumen_so->judul_dokumen_spk}}"> {{$dokumen_so->judul_dokumen_spk}}</option>
                </select>

                <input type="hidden" value="{{$dokumen_so->nama_customer}}" name="input_nama_customer" id="input_nama_customer">
                <input type="hidden" value="{{$dokumen_so->alamat_customer}}" name="input_alamat_customer" id="input_alamat_customer">
                <div>
                    <textarea rows="3" cols="55" name="data_customer" id="input_data_customer" placeholder="Data Customer" readonly style="width: 100%">
                        {{$dokumen_so->nama_customer}}
                        {{$dokumen_so->alamat_customer}}
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

            <div class="table-wrapper"  style="width: 100%;margin-top: 15px">
                <table style="width: 100%">
                    <thead id="thead_dokumen_so">
                        <th>Item</th>
                        <th>Description</th>
                        <th>QTY</th>
                        @if($list_relasi[0]->container_service != null)
                            <th>container</th>
                        @endif
                        <th>Unit Price</th>
                        <th>Disc%</th>
                        <th>Tax</th>
                        <th>Amount</th>
                        <th>Active</th>
                    </thead>
                    <tbody id="tbody_dokumen_so">
                        <?php $nomor_urut_dokumen = 0?>
                        @foreach ($list_relasi as $relasi)
                        <tr>
                            <td>{{$nomor_urut_dokumen + 1}}</td>
                            <td>
                                <input type="text" style = "width:200px;" name="input_nama_service[]" value="{{$relasi->nama_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px;" name="input_quantity_service[]" value="{{$relasi->quantity_service}}">
                            </td>
                            @if($relasi->container_service != null)
                                <td>
                                    <input type="text" style = "width:40px;" readonly name="input_container_service[]" value="{{$relasi->container_service}}">
                                </td>
                            @endif
                            <td>
                                <input type="text" style = "width:80px;" readonly name="input_harga_service[]" value="{{$relasi->harga_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px" name="input_diskon_service[]" value="{{$relasi->diskon_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:40px" name="input_pajak_service[]" value="{{$relasi->pajak_service}}">
                            </td>
                            <td>
                                <input type="text" style = "width:80px" name="input_total[]" value = "{{$relasi->total_service}}">
                            </td>
                            <td>
                                <label>
                                    <input type="checkbox" name="checkbox_status_service[]" value={{$nomor_urut_dokumen}} class="checkbox_status" checked>
                                </label>
                            </td>
                        </tr>
                        <?php $nomor_urut_dokumen++?>
                        @endforeach

                        @for ($i = 0; $i < count($list_service_unchecked); ++$i)
                            <tr>
                                <td>{{$nomor_urut_dokumen + 1}}</td>
                                <td>
                                    <input type="text" style = "width:200px;" name="input_nama_service[]" value="{{$list_service_unchecked[$i]->nama_extra_service}}">
                                </td>
                                <td>
                                    <input type="text" style = "width:40px;" name="input_quantity_service[]" value="1">
                                </td>
                                @if($list_service_unchecked[$i]->container != null)
                                    <td>
                                        <input type="text" style = "width:40px;" readonly name="input_container_service[]" value="{{$list_service_unchecked[$i]->container}}">
                                    </td>
                                @endif
                                <td>
                                    <input type="text" style = "width:80px;" readonly name="input_harga_service[]" value="{{$list_service_unchecked[$i]->harga_extra_service}}">
                                </td>
                                <td>
                                    <input type="text" style = "width:40px" name="input_diskon_service[]" value="0" value="{{$list_service_unchecked[$i]->diskon_service}}">
                                </td>
                                <td>
                                    <input type="text" style = "width:40px" name="input_pajak_service[]" value="0" value="{{$list_service_unchecked[$i]->pajak_service}}">
                                </td>
                                <td>
                                    <input type="text" style = "width:80px" name="input_total[]" value = "{{$list_service_unchecked[$i]->harga_extra_service}}">
                                </td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="checkbox_status_service[]" value={{$nomor_urut_dokumen}} class="checkbox_status" >
                                    </label>
                                </td>
                            </tr>
                            <?php $nomor_urut_dokumen++?>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class = "btn_submit_spk" style="display: inline-block">
                <button type="submit" class="button"><span>Create Document</span></button>
            </div>

        </form>

    </section>
    <script>
        $(document).ready(function () {
        });
    </script>
</div>
@endsection
