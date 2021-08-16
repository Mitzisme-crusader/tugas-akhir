<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenSpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_spk', function (Blueprint $table) {
            $table->bigIncrements('id_dokumenSpk');
            $table->string('judul_dokumen');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customer');
            $table->string('nama_customer');
            $table->string('nama_perusahaan_customer');
            $table->string('negara_customer');
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
        Schema::dropIfExists('dokumen_spk');
    }
}
