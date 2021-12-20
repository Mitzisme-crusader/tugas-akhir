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
                    <th>Nomor SO</th>
                    <th>Nama Vendor</th>
                    <th>Nama Service</th>
                    <th>Total</th>
                    <th>Hutang</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @foreach($list_dokumen_SO as $dokumen_so)
                    <tr>
                        <td>{{$dokumen_so->nomor_so}}</td>
                        <td>{{$dokumen_so->tanggal_so}}</td>
                        <td>{{$dokumen_so->Total}}</td>
                        <td>{{$dokumen_so->hutang}}</td>
                        <td>
                            <span>
                                @if ($dokumen_so->hutang > 0)
                                    Belum Lunas
                                @else
                                    Lunas
                                @endif
                            </span>
                        </td>
                        <td>
                            <form action="{{url('admin/edit_dokumen_so')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="id_dokumen_so" value="{{$dokumen_so->id_dokumen_so}}">
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
