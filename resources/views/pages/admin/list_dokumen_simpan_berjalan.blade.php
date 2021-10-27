@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/list_document_SPK.css') }}">
@endsection

@section('content')
<div class="content">
    <section>
        <h1 style="display:inline-block">List Dokumen Simpan Berjalan</h1>
        <div class="search-container">
            <form action="{{url('admin/search_dokumen_simpan_berjalan')}}" method="GET" style="display: inline-block">
                <div style="display: inline-block">
                    <div style="display: block">
                        <input id ="query_search" type="text" placeholder="Search.." name="query_search">
                        <label style="height: 50px;width:50px"> In</label>
                        <select name="list_option_table" class="list_option_table" id="list_option_table">
                            <option value="id_dokumen_simpan_berjalan">ID dokumen simpan berjalan</option>
                            <option value="nomor_SO">Nomor SO</option>
                            <option value="nama_customer">Nama Customer</option>
                            <option value="negara_customer">Negara Customer</option>
                        </select>
                    </div>
                    <div style="display: block">
                        @if($range_month == "")
                            <input type="month" class="input_search_date_tabel" name="range_month" value="<?php echo date('Y-m'); ?>">
                        @else
                            <input type="month" class="input_search_date_tabel" name="range_month" value={{$range_month}}>
                        @endif
                    </div>
                </div>
                <div style="display: inline-block;height:44px">
                    <button type="submit" style="display: inline"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>Id_dokumen</th>
                    <th>Nomor SO</th>
                    <th>Nomor Aju</th>
                    <th>Consignee</th>
                    <th>Nama Customer</th>
                    <th>Estimated Time Arrival</th>
                    <th>Kode Warna</th>
                    <th>edit</th>
                    <th>delete</th>
                </thead>
                <tbody>
                    @foreach($list_dokumen_simpan_berjalan as $dokumen_simpan_berjalan)
                    <tr>
                        <td>{{$dokumen_simpan_berjalan->id_dokumen_simpan_berjalan}}</td>
                        <td>{{$dokumen_simpan_berjalan->nomor_SO}}</td>
                        <td>{{$dokumen_simpan_berjalan->nomor_aju}}</td>
                        <td>{{$dokumen_simpan_berjalan->consignee}}</td>
                        <td>{{$dokumen_simpan_berjalan->nama_customer}}</td>
                        @if ($dokumen_simpan_berjalan->ETA == null)
                            <td>N\A</td>
                        @else
                            <td>{{$dokumen_simpan_berjalan->ETA}}
                                @if ($dokumen_simpan_berjalan->sending == null)
                                    <span><i class="fas fa-exclamation-circle"></i></span>
                                @endif
                            </td>
                        @endif
                        @if($dokumen_simpan_berjalan->option_pengiriman == "jasa")
                            <td style="background-color: cornflowerblue"><span><i class="fas fa-people-carry"></i></span></td>
                        @elseif ($dokumen_simpan_berjalan->option_pengiriman == "local")
                            <td style="background-color: grey"><span><i class="fas fa-people-carry"></i></span></td>'
                        @elseif ($dokumen_simpan_berjalan->option_container == "LCL")
                            <td style="background-color: greenyellow"><span><i class="fas fa-people-carry"></i></span></td>
                        @else
                            <td style=""><span><i class="fas fa-people-carry"></i></span></td>
                        @endif
                        <td>
                            <form action="{{url('admin/detail_dokumen_simpan_berjalan')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen" value="{{$dokumen_simpan_berjalan->id_dokumen_simpan_berjalan}}">
                                <button type="submit" class="button"><span>Detail</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_dokumen_SPK')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen" value="{{$dokumen_simpan_berjalan->id_dokumen_simpan_berjalan}}">
                                <button type="submit" class="button"><span>Delete</span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>

                    </tfoot> --}}
            </table>
        </div>
    </section>
</div>
@endsection
