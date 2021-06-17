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
                    <th>No</th>
                    <th>Name</th>
                    <th>Nutrition Info</th>
                    <th>Step by Step</th>
                    <th class="table-image">Thumbnail</th>
                    <th>Action</th>
                    <th>Edit</th>
                </thead>
                <tbody>
                    @foreach($list_resep as $resep)
                    <tr>
                        <td>{{$resep->id_resep}}</td>
                        <td>{{$resep->nama_resep}}</td>
                        <td>{!!$resep->informasi_nutrisi!!}</td>
                        <td>{!!$resep->step_by_step!!}</td>
                        <td class="table-image"><img src="{{asset($resep->path_thumbnail_resep)}}" alt=""></td>
                        <td>
                            <form action="{{url('admin/edit_resep')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_resep" value="{{$resep->id_resep}}">
                                <button type="submit" class="button"><span>Edit</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_resep')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_resep" value="{{$resep->id_resep}}">
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
