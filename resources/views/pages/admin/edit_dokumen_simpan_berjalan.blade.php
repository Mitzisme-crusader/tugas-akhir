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
        <h1>Edit Dokumen Simpan Berjalan</h1>
        @if (Session::has('message'))
            <h4 class="message">{{ Session::get('message') }}</h4>
        @endif
        <form action="{{ url('admin/proses_save_dokumen_simpan_berjalan') }}" class = "form_add" method="post">
            @csrf
            <input type="hidden" name="id_dokumen" value="{{$dokumen_simpan_berjalan->id_dokumen_simpan_berjalan}}">
            <div class="input-wrapper">
                <input type="nomor_SO" name="nomor_SO" id="nomor_SO"
                    value="{{$dokumen_simpan_berjalan->nomor_SO}}">
                <label for="nomor_SO"><span>Nomor SO</span></label>
                <span class="error-message">{{ $errors->first('nomor_SO') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="nomor_aju" name="nomor_aju" id="nomor_aju"
                    value="{{$dokumen_simpan_berjalan->nomor_aju}}">
                <label for="nomor_aju"><span> Nomor Aju</span></label>
                <span class="error-message">{{ $errors->first('nomor_aju') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="consignee" name="consignee" id="consignee"
                    value="{{$dokumen_simpan_berjalan->consignee}}">
                <label for="consignee"><span> Consignee</span></label>
                <span class="error-message">{{ $errors->first('consignee') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="notify_party" name="notify_party" id="notify_party"
                    value="{{$dokumen_simpan_berjalan->notify_party}}">
                <label for="notify_party"><span> Notify Party</span></label>
                <span class="error-message">{{ $errors->first('notify_party') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="customer" name="customer" id="customer"
                    value="{{$dokumen_simpan_berjalan->nama_customer}}">
                <label for="customer"><span>Nama Customer</span></label>
                <span class="error-message">{{ $errors->first('customer') }}</span>
            </div>
            <div class="input-wrapper">
                <input type="verification_order" name="verification_order" id="verification_order"
                    value="{{$dokumen_simpan_berjalan->verification_order}}">
                <label for="verification_order"><span> Verification Order</span></label>
                <span class="error-message">{{ $errors->first('verification_order') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="commodity" name="commodity" id="commodity"
                    value="{{$dokumen_simpan_berjalan->commodity}}">
                <label for="commodity"><span> Commodity</span></label>
                <span class="error-message">{{ $errors->first('commodity') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white;"> EXIM</span></label>

            <div>
                <select name="option_pengiriman">
                    <option value="export" @if($dokumen_simpan_berjalan->option_pengiriman == "export") selected="selected"@endif>Export</option>
                    <option value="import" @if($dokumen_simpan_berjalan->option_pengiriman == "import") selected="selected"@endif>Import</option>
                    <option value="jasa"   @if($dokumen_simpan_berjalan->option_pengiriman == "jasa") selected="selected"@endif>Jasa</option>
                    <option value="local"  @if($dokumen_simpan_berjalan->option_pengiriman == "local") selected="selected"@endif>Lokal</option>
                </select>
            </div>

            <div class="input-wrapper">
                <input type="POL" name="POL" id="POL"
                    value="{{$dokumen_simpan_berjalan->POL}}">
                <label for="POL"><span> POL</span></label>
                <span class="error-message">{{ $errors->first('POL') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="POD" name="POD" id="POD"
                    value="{{$dokumen_simpan_berjalan->POD}}">
                <label for="POD" ><span> POD</span></label>
                <span class="error-message">{{ $errors->first('POD') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Party</span></label>

            <div>
                <select name="option_container" id="option_container">
                    <option value="FCL" @if($dokumen_simpan_berjalan->option_container == "FCL") selected="selected"@endif>FCL</option>
                    <option value="LCL" @if($dokumen_simpan_berjalan->option_container == "LCL") selected="selected"@endif>LCL</option>
                </select>
            </div>

            <div id = "input_FCL">
                <div class="input-wrapper">
                    <input type="party_20" name="party_20" id="party_20"
                        value="{{$dokumen_simpan_berjalan->party_20}}">
                    <label for="party_20"><span> 20</span></label>
                    <span class="error-message">{{ $errors->first('party_20') }}</span>
                </div>

                <div class="input-wrapper">
                    <input type="party_40" name="party_40" id="party_40"
                        value="{{$dokumen_simpan_berjalan->party_40}}">
                    <label for="party_40"><span> 40</span></label>
                    <span class="error-message">{{ $errors->first('party_40') }}</span>
                </div>

                <div class="input-wrapper">
                    <input type="party_45" name="party_45" id="party_45"
                        value="{{$dokumen_simpan_berjalan->party_45}}">
                    <label for="party_45"><span> 45</span></label>
                    <span class="error-message">{{ $errors->first('party_45') }}</span>
                </div>
            </div>

            <div id = "input_LCL" style="display: none">
                <div class="input-wrapper">
                    <input type="berat_container" name="berat_container" id="berat_container"
                        value="{{$dokumen_simpan_berjalan->berat_container}}">
                    <label for="berat_container"><span> Berat Container</span></label>
                    <span class="error-message">{{ $errors->first('berat_container') }}</span>
                </div>
            </div>

            <div class="input-wrapper">
                <input type="nomor_container" name="nomor_container" id="nomor_container"
                    value="{{$dokumen_simpan_berjalan->nomor_container}}">
                <label for="nomor_container"><span> Nomor Container</span></label>
                <span class="error-message">{{ $errors->first('nomor_container') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nomor_invoice" name="nomor_invoice" id="nomor_invoice"
                    value="{{$dokumen_simpan_berjalan->nomor_invoice}}">
                <label for="nomor_invoice"><span> Nomor Invoice</span></label>
                <span class="error-message">{{ $errors->first('nomor_invoice') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="vessal" name="vessal" id="vessal"
                    value="{{$dokumen_simpan_berjalan->vessal}}">
                <label for="vessal"><span> Vessal</span></label>
                <span class="error-message">{{ $errors->first('vessal') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nomor_BL" name="nomor_BL" id="nomor_BL"
                    value="{{$dokumen_simpan_berjalan->nomor_BL}}">
                <label for="nomor_BL"><span> Nomor Bill of Lading</span></label>
                <span class="error-message">{{ $errors->first('nomor_BL') }}</span>
            </div>

            <label for="ETD"><span> Estimated time of departure</span></label>
            <div class="input-wrapper">
                <input type="date" name="ETD" id="ETD"
                    value="{{$dokumen_simpan_berjalan->ETD}}">
                <span class="error-message">{{ $errors->first('ETD') }}</span>
            </div>

            <label for="ETA"><span> Estimated time of Arrival</span></label>
            <div class="input-wrapper">
                <input type="date" name="ETA" id="ETA"
                    value="{{$dokumen_simpan_berjalan->ETA}}">
                <span class="error-message">{{ $errors->first('ETA') }}</span>
            </div>

            <label for="tanggal_terima_dokumen"><span> Tanggal Terima Dokumen/ Stuffing</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_terima_dokumen" id="tanggal_terima_dokumen"
                    value="{{$dokumen_simpan_berjalan->tanggal_terima_dokumen}}">
                <span class="error-message">{{ $errors->first('tanggal_terima_dokumen') }}</span>
            </div>

            <label for="sending"><span> Sending</span></label>
            <div class="input-wrapper">
                <input type="date" name="sending" id="sending"
                    value="{{$dokumen_simpan_berjalan->sending}}">
                <span class="error-message">{{ $errors->first('sending') }}</span>
            </div>

            <label for="tanggal_nopen"><span> Tanggal Penerimaan Nopen</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_nopen" id="tanggal_nopen"
                    value="{{$dokumen_simpan_berjalan->tanggal_nopen}}">
                <span class="error-message">{{ $errors->first('tanggal_nopen') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Nomor Pendaftaran</span></label>

            <div>
                <select name="list_surat_penjaluran">
                    <option value="">Pilih Opsi Surat Penjaluran</option>
                    <option value="SPJM" @if($dokumen_simpan_berjalan->opsi_surat_penjaluran == "SPJM") selected="selected"@endif>SPJM</option>
                    <option value="SPJK" @if($dokumen_simpan_berjalan->opsi_surat_penjaluran == "SPJK") selected="selected"@endif>SPJK</option>
                    <option value="SPJH" @if($dokumen_simpan_berjalan->opsi_surat_penjaluran == "SPJH") selected="selected"@endif>SPJH</option>
                </select>
                <div class="input-wrapper">
                    <input type="nomor_surat_penjaluran" name="nomor_surat_penjaluran" id="nomor_surat_penjaluran"
                        value="{{$dokumen_simpan_berjalan->nomor_surat_penjaluran}}">
                    <label for="nomor_surat_penjaluran"><span> Nomor Surat Penjaluran</span></label>
                    <span class="error-message">{{ $errors->first('nomor_surat_penjaluran') }}</span>
                </div>
            </div>

            <div class="input-wrapper">
                <input type="jumlah_PIB" name="jumlah_PIB" id="jumlah_PIB"
                    value="{{$dokumen_simpan_berjalan->jumlah_PIB}}">
                <label for="jumlah_PIB"><span> Harga PIB</span></label>
                <span class="error-message">{{ $errors->first('jumlah_PIB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="jumlah_notul" name="jumlah_notul" id="jumlah_notul"
                    value="{{$dokumen_simpan_berjalan->jumlah_notul}}">
                <label for="jumlah_notul"><span> Jumlah Notul</span></label>
                <span class="error-message">{{ $errors->first('jumlah_notul') }}</span>
            </div>


            <label for="tanggal_pemeriksaan_barang"><span> Tanggal Pemeriksaan Barang</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_pemeriksaan_barang" id="tanggal_pemeriksaan_barang"
                    value="{{$dokumen_simpan_berjalan->tanggal_pemeriksaan_barang}}">
                <span class="error-message">{{ $errors->first('tanggal_pemeriksaan_barang') }}</span>
            </div>

            <label for="DNP"><span> DNP </span></label>
            <div class="input-wrapper">
                <input type="date" name="DNP" id="DNP"
                    value="{{$dokumen_simpan_berjalan->tanggal_DNP}}">
                <span class="error-message">{{ $errors->first('DNP') }}</span>
            </div>

            <label for="tanggal_SPPB"><span> Tanggal SPPB</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_SPPB" id="tanggal_SPPB"
                    value="{{$dokumen_simpan_berjalan->tanggal_SPPB}}">
                <span class="error-message">{{ $errors->first('tanggal_SPPB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="SPPB" name="SPPB" id="SPPB"
                    value="{{$dokumen_simpan_berjalan->SPPB}}">
                <label for="SPPB"><span> SPPB</span></label>
                <span class="error-message">{{ $errors->first('SPPB') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="tempat_penimbunan" name="tempat_penimbunan" id="tempat_penimbunan"
                    value="{{$dokumen_simpan_berjalan->tempat_penimbunan}}">
                <label for="tempat_penimbunan"><span> Tempat Penimbunan</span></label>
                <span class="error-message">{{ $errors->first('tempat_penimbunan') }}</span>
            </div>

            <label for="tanggal_kirim"><span> Tanggal Kirim</span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_kirim" id="tanggal_kirim"
                    value="{{$dokumen_simpan_berjalan->tanggal_pengiriman}}">
                <span class="error-message">{{ $errors->first('tanggal_kirim') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="alamat_pembongkaran" name="alamat_pembongkaran" id="alamat_pembongkaran"
                    value="{{$dokumen_simpan_berjalan->alamat_pembongkaran}}">
                <label for="alamat_pembongkaran"><span> Alamat Pembongkaran</span></label>
                <span class="error-message">{{ $errors->first('alamat_pembongkaran') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="pemilik_trucking" name="pemilik_trucking" id="pemilik_trucking"
                    value="{{$dokumen_simpan_berjalan->pemilik_trucking}}">
                <label for="pemilik_trucking"><span> Pemilik Trucking</span></label>
                <span class="error-message">{{ $errors->first('pemilik_trucking') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="nopol_supir" name="nopol_supir" id="nopol_supir"
                    value="{{$dokumen_simpan_berjalan->nopol_supir}}">
                <label for="nopol_supir"><span> Nomor Polisi atau kontak pengirim</span></label>
                <span class="error-message">{{ $errors->first('nopol_supir') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="balik_depo" name="balik_depo" id="balik_depo"
                    value="{{$dokumen_simpan_berjalan->balik_depo}}">
                <label for="balik_depo"><span> Balik Depo</span></label>
                <span class="error-message">{{ $errors->first('balik_depo') }}</span>
            </div>

            <label for="tanggal_depo_kembali"><span> Tanggal Depo Kembali  </span></label>
            <div class="input-wrapper">
                <input type="date" name="tanggal_depo_kembali" id="tanggal_depo_kembali"
                    value="{{$dokumen_simpan_berjalan->tanggal_depo_kembali}}">
                <span class="error-message">{{ $errors->first('tanggal_depo_kembali') }}</span>
            </div>

            <div class="input-wrapper">
                <input type="harga_trucking" name="harga_trucking" id="harga_trucking"
                    value="{{$dokumen_simpan_berjalan->harga_trucking}}">
                <label for="harga_trucking"><span> Harga Trucking</span></label>
                <span class="error-message">{{ $errors->first('harga_trucking') }}</span>
            </div>

            <label ><span style="background-color: var(--primary_color) ;color:white"> Asuransi</span></label>

            <div>
                <select name="option_asal_asuransi">
                    <option value="luar_negeri" @if($dokumen_simpan_berjalan->opsi_asal_asuransi  == "luar_negeri") selected="selected"@endif>Luar Negeri</option>
                    <option value="dalam_negeri" @if($dokumen_simpan_berjalan->opsi_asal_asuransi == "dalam_neger") selected="selected"@endif>Dalam Negeri</option>
                </select>
                <div class="input-wrapper">
                    <input type="nama_asuransi" name="nama_asuransi" id="nama_asuransi"
                        value="{{$dokumen_simpan_berjalan->nama_asuransi}}">
                    <label for="nama_asuransi"><span> Nama Asuransi</span></label>
                    <span class="error-message">{{ $errors->first('nama_asuransi') }}</span>
                </div>
                <div class="input-wrapper">
                    <input type="harga_asuransi" name="harga_asuransi" id="harga_asuransi"
                        value="{{$dokumen_simpan_berjalan->harga_asuransi}}">
                    <label for="harga_asuransi"><span> Harga Asuransi</span></label>
                    <span class="error-message">{{ $errors->first('harga_asuransi') }}</span>
                </div>
            </div>

            <button type="submit" class="button"><span>Save Dokumen Simpan Berjalan</span></button>
        </form>
    </section>
</div>
@endsection
