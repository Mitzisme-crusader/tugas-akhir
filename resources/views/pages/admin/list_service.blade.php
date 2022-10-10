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
        <h1>List Service</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                    <th>edit</th>
                    <th>delete</th>
                </thead>
                <tbody>
                    {{-- @foreach($list_service as $service)
                    <tr>
                        <td>{{$service->id_service}}</td>
                        <td>{{$service->nama_service}}</td>
                        <td>
                            <textarea cols="50" rows="4" readonly>{{$service->deskripsi_service}}</textarea>
                        </td>
                        <td>{{$service->biaya_service}}</td>
                        <td>
                            <form action="{{url('admin/edit_service')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_service" value="{{$service->id_service}}">
                                <button type="submit" class="button"><span>Edit</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_service')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_service" value="{{$service->id_service}}">
                                <button type="submit" class="button"><span>Delete</span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach --}}
                </tbody>
                {{-- <tfoot>

                    </tfoot> --}}
            </table>
        </div>
    </section>
</div>
@endsection
