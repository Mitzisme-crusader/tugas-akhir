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
        <h1>List Tagihan Vendor</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <th>Nomor SO</th>
                    <th>Date Created</th>
                    <th>Total</th>
                    <th>Owing</th>
                    <th>Status</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @foreach($list_tagihan_vendor as $tagihan_vendor)
                    <tr>
                        <td>{{$tagihan_vendor->nomor_so}}</td>
                        <td>{{date('d-m-Y',strtotime($tagihan_vendor->created_at))}}</td>
                        <td>{{$tagihan_vendor->total_service}}</td>
                        <td>{{$tagihan_vendor->hutang}}</td>
                        <td>
                            <span>
                                @if ($tagihan_vendor->hutang > 0)
                                    Belum Lunas
                                @else
                                    Lunas
                                @endif
                            </span>
                        </td>
                        <td>
                            <form action="{{url('admin/detail_tagihan_vendor')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_tagihan_vendor" value="{{$tagihan_vendor->id_tagihan_vendor}}">
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
