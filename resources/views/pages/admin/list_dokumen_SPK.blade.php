@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/list_document_SPK.css') }}">
@endsection

@section('content')
<div class="content" style="width: 75%">
    <section>
        <h1 style="display:inline-block">List Dokumen SPK</h1>
        <div class="search-container">
            <form action="{{url('admin/search_SPK')}}" method="GET" style="display: inline-block">
                <div style="display: inline-block">
                    <div style="display: block">
                        <input id ="query_search" type="text" placeholder="Search.." name="query_search">
                        <label style="height: 50px;width:50px"> In</label>
                        <select name="list_option_table" class="list_option_table" id="list_option_table">
                            <option value="id_dokumen_spk">ID dokumen</option>
                            <option value="judul_dokumen">Judul dokumen</option>
                            <option value="nama_customer">Nama Customer</option>
                            <option value="negara_customer">Negara Customer</option>
                        </select>
                    </div>
                    <div style="display: block">
                        <input type="date" class="input_search_date_tabel" name="range_date_search_awal" >
                        <label style="margin-left: 2px;margin-right:5px"> / </label>
                        <input type="date" class="input_search_date_tabel" name="range_date_search_akhir" value="<?php echo date('Y-m-d'); ?>">
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
                    <th>Judul Dokumen</th>
                    <th>Nama Customer</th>
                    <th>Negara Customer</th>
                    <th>Nama Perusahaan Customer</th>
                    <th>Tanggal Dibuat</th>
                    <th>edit</th>
                    <th>delete</th>
                </thead>
                <tbody>
                    @foreach($list_dokumen_SPK as $dokumen_SPK)
                    <tr>
                        <td>{{$dokumen_SPK->id_dokumen_spk}}</td>
                        <td>{{$dokumen_SPK->judul_dokumen}}</td>
                        <td>{{$dokumen_SPK->nama_customer}}</td>
                        <td>{{$dokumen_SPK->negara_customer}}</td>
                        <td>{{$dokumen_SPK->nama_perusahaan_customer}}</td>
                        <td>{{date($dokumen_SPK->created_at)}}</td>
                        <td>
                            <form action="{{url('admin/edit_dokumen_SPK')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen" value="{{$dokumen_SPK->id_dokumen_spk}}">
                                <button type="submit" class="button"><span>Edit</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_dokumen_SPK')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen" value="{{$dokumen_SPK->id_dokumen_spk}}">
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
