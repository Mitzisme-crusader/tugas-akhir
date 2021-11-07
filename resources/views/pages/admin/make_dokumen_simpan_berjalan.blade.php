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
        <h1 class="title_document">Add New Dokumen Simpan Berjalan</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_add_dokumen_simpan_berjalan') }}" class = "form_add" method="post">
            @csrf
            <div class="input-wrapper">
                <input type="nomor_SO" name="nomor_SO" id="nomor_SO"
                    value="{{old('nomor_SO')}}">
                <label for="nomor_SO"><span>Nomor SO</span></label>
                <span class="error-message">{{ $errors->first('nomor_SO') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="nomor_aju" name="nomor_aju" id="nomor_aju"
                    value="{{old('nomor_aju')}}">
                <label for="nomor_aju"><span> Nomor Aju</span></label>
                <span class="error-message">{{ $errors->first('nomor_aju') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="consignee" name="consignee" id="consignee"
                    value="{{old('consignee')}}">
                <label for="consignee"><span> Consignee</span></label>
                <span class="error-message">{{ $errors->first('consignee') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="notify_party" name="notify_party" id="notify_party"
                    value="{{old('notify_party')}}">
                <label for="notify_party"><span> Notify Party</span></label>
                <span class="error-message">{{ $errors->first('notify_party') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="customer" name="customer" id="customer"
                    value="{{old('customer')}}">
                <label for="customer"><span>Nama Customer</span></label>
                <span class="error-message">{{ $errors->first('customer') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="verification_order" name="verification_order" id="verification_order"
                    value="{{old('verification_order')}}">
                <label for="verification_order"><span> Verification Order</span></label>
                <span class="error-message">{{ $errors->first('verification_order') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="commodity" name="commodity" id="commodity"
                    value="{{old('comodity')}}">
                <label for="commodity"><span> Commodity</span></label>
                <span class="error-message">{{ $errors->first('commodity') }}</span>
            </div>

            <label class="label_info">EXIM</label>

            <div>
                <select name="option_pengiriman">
                    <option value="export">Export</option>
                    <option value="import">Import</option>
                    <option value="jasa" > Jasa</option>
                    <option value="local"> Lokal</option>
                 </select>
            </div>

            <div class="input-wrapper">
                <input type="POL" name="POL" id="POL"
                    value="{{old('POL')}}">
                <label for="POL"><span> POL</span></label>
                <span class="error-message">{{ $errors->first('POL') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="POD" name="POD" id="POD"
                    value="{{old('POD')}}">
                <label for="POD" ><span> POD</span></label>
                <span class="error-message">{{ $errors->first('POD') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Party</span></label>

            <div>
                <select name="option_container" id="option_container">
                    <option value="FCL">FCL</option>
                    <option value="LCL">LCL</option>
                </select>
            </div>

            <div id = "input_FCL">
                <div class="input-wrapper">
                    <input type="party_20" name="party_20" id="party_20"
                        value="{{old('party_20')}}">
                    <label for="party_20"><span> 20</span></label>
                    <span class="error-message">{{ $errors->first('party_20') }}</span>
                </div>

                <div class="input-wrapper">
                    <input type="party_40" name="party_40" id="party_40"
                        value="{{old('party_40')}}">
                    <label for="party_40"><span> 40</span></label>
                    <span class="error-message">{{ $errors->first('party_40') }}</span>
                </div>

                <div class="input-wrapper">
                    <input type="party_45" name="party_45" id="party_45"
                        value="{{old('party_45')}}">
                    <label for="party_45"><span> 45</span></label>
                    <span class="error-message">{{ $errors->first('party_45') }}</span>
                </div>
            </div>

            <div id = "input_LCL" style="display: none">
                <div class="input-wrapper">
                    <input type="berat_container" name="berat_container" id="berat_container"
                        value="{{old('berat_container')}}">
                    <label for="berat_container"><span> Berat Container</span></label>
                    <span class="error-message">{{ $errors->first('berat_container') }}</span>
                </div>
            </div>

            <div class="input-wrapper">
                <input type="nomor_container" name="nomor_container" id="nomor_container"
                    value="{{old('nomor_container')}}">
                <label for="nomor_container"><span> Nomor Container</span></label>
                <span class="error-message">{{ $errors->first('nomor_container') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nomor_invoice" name="nomor_invoice" id="nomor_invoice"
                    value="{{old('nomor_invoice')}}">
                <label for="nomor_invoice"><span> Nomor Invoice</span></label>
                <span class="error-message">{{ $errors->first('nomor_invoice') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="vessal" name="vessal" id="vessal"
                    value="{{old('vessal')}}">
                <label for="vessal"><span> Vessal</span></label>
                <span class="error-message">{{ $errors->first('vessal') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nomor_BL" name="nomor_BL" id="nomor_BL"
                    value="{{old('nomor_BL')}}">
                <label for="nomor_BL"><span> Nomor Bill of Lading</span></label>
                <span class="error-message">{{ $errors->first('nomor_BL') }}</span>
            </div>

            <label for="ETD"><span> Estimated time of departure</span></label>
            <div class="input-wrapper">
                <input type="date" name="ETD" id="ETD"
                    value="{{old('ETD')}}">
                <span class="error-message">{{ $errors->first('ETD') }}</span>
            </div>

            <label for="ETA"><span> Estimated time of Arrival</span></label>
            <div class="input-wrapper">
                <input type="date" name="ETA" id="ETA"
                    value="{{old('ETA')}}">
                <span class="error-message">{{ $errors->first('ETA') }}</span>
            </div>

            <label for="tanggal_terima_dokumen"><span> Tanggal Terima Dokumen/ Stuffing</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_terima_dokumen" id="tanggal_terima_dokumen"
                    value="{{old('tanggal_terima_dokumen')}}">
                <span class="error-message">{{ $errors->first('tanggal_terima_dokumen') }}</span>
            </div>

            <label for="sending"><span> Sending</span></label>
            <div class="input-wrapper">
                <input type="date" name="sending" id="sending"
                    value="{{old('sending')}}">
                <span class="error-message">{{ $errors->first('sending') }}</span>
            </div>

            <label for="tanggal_nopen"><span> Tanggal Penerimaan Nopen</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_nopen" id="tanggal_nopen"
                    value="{{old('tanggal_nopen')}}">
                <span class="error-message">{{ $errors->first('tanggal_nopen') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Nomor Pendaftaran</span></label>

            <div>
                <select name="list_surat_penjaluran" id="list_surat_penjaluran">
                    <option value="">Pilih Opsi Surat Penjaluran</option>
                    <option value="SPJM">SPJM</option>
                    <option value="SPJK">SPJK</option>
                    <option value="SPJH">SPJH</option>
                </select>
                <div class="input-wrapper">
                    <input type="nomor_surat_penjaluran" name="nomor_surat_penjaluran" id="nomor_surat_penjaluran"
                        value="{{old('nomor_surat_penjaluran')}}">
                    <label for="nomor_surat_penjaluran"><span> Nomor Surat Penjaluran</span></label>
                    <span class="error-message">{{ $errors->first('nomor_surat_penjaluran') }}</span>
                </div>
            </div>

            <div class="input-wrapper">
                <input type="jumlah_PIB" name="jumlah_PIB" id="jumlah_PIB"
                    value="{{old('jumlah_PIB')}}">
                <label for="jumlah_PIB"><span> Harga PIB</span></label>
                <span class="error-message">{{ $errors->first('jumlah_PIB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="jumlah_notul" name="jumlah_notul" id="jumlah_notul"
                    value="{{old('jumlah_notul')}}">
                <label for="jumlah_notul"><span> Jumlah Notul</span></label>
                <span class="error-message">{{ $errors->first('jumlah_notul') }}</span>
            </div>


            <label for="tanggal_pemeriksaan_barang"><span> Tanggal Pemeriksaan Barang</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_pemeriksaan_barang" id="tanggal_pemeriksaan_barang"
                    value="{{old('tanggal_pemeriksaan_barang')}}">
                <span class="error-message">{{ $errors->first('tanggal_pemeriksaan_barang') }}</span>
            </div>

            <label for="DNP"><span> DNP </span></label>
            <div class="input-wrapper">
                <input type="date" name="DNP" id="DNP"
                    value="{{old('DNP')}}">
                <span class="error-message">{{ $errors->first('DNP') }}</span>
            </div>

            <label for="tanggal_SPPB"><span> Tanggal SPPB</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_SPPB" id="tanggal_SPPB"
                    value="{{old('tanggal_SPPB')}}">
                <span class="error-message">{{ $errors->first('tanggal_SPPB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="SPPB" name="SPPB" id="SPPB"
                    value="{{old('SPPB')}}">
                <label for="SPPB"><span> SPPB</span></label>
                <span class="error-message">{{ $errors->first('SPPB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="tempat_penimbunan" name="tempat_penimbunan" id="tempat_penimbunan"
                    value="{{old('tempat_penimbunan')}}">
                <label for="tempat_penimbunan"><span> Tempat Penimbunan</span></label>
                <span class="error-message">{{ $errors->first('tempat_penimbunan') }}</span>
            </div>

            <label for="tanggal_kirim"><span> Tanggal Kirim</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_kirim" id="tanggal_kirim"
                    value="{{old('tanggal_kirim')}}">
                <span class="error-message">{{ $errors->first('tanggal_kirim') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="alamat_pembongkaran" name="alamat_pembongkaran" id="alamat_pembongkaran"
                    value="{{old('alamat_pembongkaran')}}">
                <label for="alamat_pembongkaran"><span> Alamat Pembongkaran</span></label>
                <span class="error-message">{{ $errors->first('alamat_pembongkaran') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="pemilik_trucking" name="pemilik_trucking" id="pemilik_trucking"
                    value="{{old('pemilik_trucking')}}">
                <label for="pemilik_trucking"><span> Pemilik Trucking</span></label>
                <span class="error-message">{{ $errors->first('pemilik_trucking') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nopol_supir" name="nopol_supir" id="nopol_supir"
                    value="{{old('nopol_supir')}}">
                <label for="nopol_supir"><span> Nomor Polisi atau kontak pengirim</span></label>
                <span class="error-message">{{ $errors->first('nopol_supir') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="balik_depo" name="balik_depo" id="balik_depo"
                    value="{{old('balik_depo')}}">
                <label for="balik_depo"><span> Balik Depo</span></label>
                <span class="error-message">{{ $errors->first('balik_depo') }}</span>
            </div>

            <label for="tanggal_depo_kembali"><span> Tanggal Depo Kembali  </span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_depo_kembali" id="tanggal_depo_kembali"
                    value="{{old('tanggal_depo_kembali')}}">
                <span class="error-message">{{ $errors->first('tanggal_depo_kembali') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="harga_trucking" name="harga_trucking" id="harga_trucking"
                    value="{{old('harga_trucking')}}">
                <label for="harga_trucking"><span> Harga Trucking</span></label>
                <span class="error-message">{{ $errors->first('harga_trucking') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Asuransi</span></label>

            <div>
                <select name="option_asal_asuransi">
                    <option value="luar_negeri">Luar Negeri</option>
                    <option value="dalam_negeri">Dalam Negeri</option>
                </select>
                <div class="input-wrapper">
                    <input type="nama_asuransi" name="nama_asuransi" id="nama_asuransi"
                        value="{{old('nama_asuransi')}}">
                    <label for="nama_asuransi"><span> Nama Asuransi</span></label>
                    <span class="error-message">{{ $errors->first('nama_asuransi') }}</span>
                </div>
                <div class="input-wrapper">
                    <input type="harga_asuransi" name="harga_asuransi" id="harga_asuransi"
                        value="{{old('harga_asuransi')}}">
                    <label for="harga_asuransi"><span> Harga Asuransi</span></label>
                    <span class="error-message">{{ $errors->first('harga_asuransi') }}</span>
                </div>
            </div>

            <button type="submit" class="button"><span>Add Dokumen Simpan Berjalan</span></button>
        </form>
    </section>
</div>

<script>
    $(document).ready(function () {
        $( "#list_surat_penjaluran" ).change(function() {
            $("#list_surat_penjaluran option[value='']").remove();
        });
    });
</script>
@endsection
