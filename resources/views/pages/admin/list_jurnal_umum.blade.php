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
        <h1 style="display:inline-block">List Jurnal Umum</h1>
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
                    <th>Tanggal Jurnal Umummm</th>
                    <th>No.Akun</th>
                    <th>Nama Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </thead>
                <tbody>
                    @foreach($list_jurnal_umum as $jurnal_umum)
                        @if($jurnal_umum->jenis_tagihan == 2 && $jurnal_umum->piutang > 0)
                            <tr>
                                <td>{{$jurnal_umum->created_at->format('Y-m-d')}} ini customer</td>
                                <td>{{$jurnal_umum->nomor_rekening}}-{{$jurnal_umum->nama_rekening}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_debit}}</td>
                                <td></td>
                            </tr>
                            @if($jurnal_umum->piutang > 0)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{$jurnal_umum->keterangan_tagihan}}</td>
                                    <td></td>
                                    <td>{{$jurnal_umum->total_debit - $jurnal_umum->piutang}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Piutang</td>
                                <td></td>
                                <td>{{$jurnal_umum->piutang}}</td>
                            </tr>
                        @elseif($jurnal_umum->jenis_tagihan == 2 && $jurnal_umum->piutang == 0)
                            <tr>
                                <td>{{$jurnal_umum->created_at->format('Y-m-d')}}</td>
                                <td>{{$jurnal_umum->nomor_rekening}}-{{$jurnal_umum->nama_rekening}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_kredit}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$jurnal_umum->keterangan_tagihan}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_kredit}}</td>
                            </tr>
                        @endif

                        @if($jurnal_umum->jenis_tagihan == 1 && $jurnal_umum->hutang > 0)
                            <tr>
                                <td>{{$jurnal_umum->created_at->format('Y-m-d')}}</td>
                                <td>{{$jurnal_umum->keterangan_tagihan}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_kredit}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$jurnal_umum->nomor_rekening}}-{{$jurnal_umum->nama_rekening}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->hutang}}</td>
                            </tr>
                            @if($jurnal_umum->hutang > 0)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>hutang</td>
                                    <td></td>
                                    <td>{{$jurnal_umum->total_kredit -$jurnal_umum->hutang}}</td>
                                </tr>
                            @endif
                        @elseif($jurnal_umum->jenis_tagihan == 1 && $jurnal_umum->piutang == 0)
                            <tr>
                                <td></td>
                                <td>{{$jurnal_umum->nomor_rekening}}-{{$jurnal_umum->nama_rekening}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_kredit}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$jurnal_umum->keterangan_tagihan}}</td>
                                <td></td>
                                <td>{{$jurnal_umum->total_kredit}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                {{-- <tfoot>

                    </tfoot> --}}
            </table>
        </div>
    </section>
</div>
@endsection
