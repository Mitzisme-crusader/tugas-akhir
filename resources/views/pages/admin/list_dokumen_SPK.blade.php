@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="content">
    <section>
        <h1>List Customer</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>Id_dokumen</th>
                    <th>Judul Dokumen</th>
                    <th>Nama Customer</th>
                    <th>Negara Customer</th>
                    <th>Nama Perusahaan Customer</th>
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
