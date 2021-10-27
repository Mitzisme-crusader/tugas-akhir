<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenSimpanBerjalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_simpan_berjalan', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen_simpan_berjalan');
            $table->string('nomor_SO');
            // $table->unsignedBigInteger('nomor_SO');
            // $table->foreign('nomor_SO')->references('nomor_SO')->on('dokumen_SO');
            $table->string('nomor_aju');
            $table->string('consignee');
            $table->string('notify_party');
            $table->string('nama_customer');
            $table->string('verification_order')->nullable();
            $table->string('commodity');
            $table->string('option_pengiriman');
            $table->string('POL');
            $table->string('POD');
            $table->string('option_container');
            $table->string('party_20')->nullable();
            $table->string('party_40')->nullable();
            $table->string('party_45')->nullable();
            $table->string('berat_container')->nullable();
            $table->string('nomor_container');
            $table->string('nomor_invoice');
            $table->string('vessal');
            $table->string('nomor_BL');
            $table->date('ETD')->nullable();
            $table->date('ETA')->nullable();
            $table->date('tanggal_terima_dokumen')->nullable();
            $table->date('sending')->nullable();
            $table->date('tanggal_nopen')->nullable();
            $table->string('opsi_surat_penjaluran')->nullable();
            $table->string('nomor_surat_penjaluran')->nullable();
            $table->bigInteger('jumlah_PIB')->nullable();
            $table->bigInteger('jumlah_notul')->nullable();
            $table->date('tanggal_pemeriksaan_barang')->nullable();
            $table->date('tanggal_DNP')->nullable();
            $table->date('tanggal_SPPB')->nullable();
            $table->string('SPPB')->nullable();
            $table->string('tempat_penimbunan')->nullable();
            $table->date('tanggal_pengiriman')->nullable();
            $table->string('alamat_pembongkaran')->nullable();
            $table->string('pemilik_trucking')->nullable();
            $table->string('nopol_supir')->nullable();
            $table->string('balik_depo')->nullable();
            $table->date('tanggal_depo_kembali')->nullable();
            $table->bigInteger('harga_trucking')->nullable();
            $table->string('opsi_asal_asuransi');
            $table->string('nama_asuransi');
            $table->bigInteger('harga_asuransi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_simpan_berjalan');
    }
}
