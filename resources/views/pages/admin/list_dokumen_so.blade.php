@extends('layout.admin_layout')

@section('title')
<title>Admin</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="content" style="width: 75%">
    <section>
        <h1>List Dokumen SO</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Judul Dokumen SPK</th>
                    <th>Nama Customer</th>
                    <th>Alamat Customer</th>
                    <th>edit</th>
                    <th>delete</th>
                </thead>
                <tbody>
                    @foreach($list_dokumen_SO as $dokumen_so)
                    <tr>
                        <td>{{$dokumen_so->nomor_so}}</td>
                        <td>{{$dokumen_so->tanggal_so}}</td>
                        <td>{{$dokumen_so->judul_dokumen_spk}}</td>
                        <td>{{$dokumen_so->nama_customer}}</td>
                        <td>
                            <textarea cols="30" rows="4" readonly>{{$dokumen_so->alamat_customer}}</textarea>
                        </td>
                        <td>
                            <form action="{{url('admin/edit_dokumen_so')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen_so" value="{{$dokumen_so->id_dokumen_so}}">
                                <button type="submit" class="button"><span>Edit</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_dokumen_so')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen_so" value="{{$dokumen_so->id_dokumen_so}}">
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
