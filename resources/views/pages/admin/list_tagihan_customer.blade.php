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
        <h1>List Tagihan Customer</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>Nomor SO</th>
                    <th>Bank Pelunasan </th>
                    <th>Total Tagihan</th>
                    <th>Date Created</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @foreach($list_tagihan_customer as $tagihan_customer)
                    <tr>
                        <td>{{$tagihan_customer->nomor_so}}</td>
                        <td>{{$tagihan_customer->bank_pelunasan}}</td>
                        <td>{{$tagihan_customer->total_service}}</td>
                        <td>{{date('d-m-Y',strtotime($tagihan_customer->created_at))}}</td>
                        <td>
                            <form action="{{url('admin/detail_tagihan_customer')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_tagihan_customer" value="{{$tagihan_customer->id_tagihan_customer}}">
                                <button type="submit" class="button"><span>Detail</span></button>
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
