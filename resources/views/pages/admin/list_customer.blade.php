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
                    <th>Nama</th>
                    <th>email</th>
                    <th>negara</th>
                    <th>nomor telepon</th>
                    <th>edit</th>
                    <th>delete</th>
                </thead>
                <tbody>
                    @foreach($list_customer as $customer)
                    <tr>
                        <td>{{$customer->id_customer}}</td>
                        <td>{{$customer->nama}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->negara}}</td>
                        <td>{{$customer->nomor_telepon}}</td>
                        <td>
                            <form action="{{url('admin/edit_customer')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_customer" value="{{$customer->id_customer}}">
                                <button type="submit" class="button"><span>Edit</span></button>
                            </form>
                        </td>
                        <td>
                            <form action="{{url('admin/delete_customer')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id_customer" value="{{$customer->id_customer}}">
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
