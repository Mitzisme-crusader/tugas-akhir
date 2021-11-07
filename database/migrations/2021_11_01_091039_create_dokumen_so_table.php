<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenSoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_so', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen_so');
            $table->string('nomor_so');
            $table->date('tanggal_so');
            $table->string('judul_dokumen_spk');
            $table->string('nama_customer');
            $table->string('alamat_customer');
            $table->integer("status_aktif_dokumen");
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
        Schema::dropIfExists('dokumen_so');
    }
}
