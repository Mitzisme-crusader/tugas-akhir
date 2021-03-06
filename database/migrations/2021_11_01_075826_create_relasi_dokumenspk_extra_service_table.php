<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelasiDokumenspkExtraServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_dokumenspk_extra_service', function (Blueprint $table) {
            $table->bigIncrements('id_relasi_dokumenspk_extra_service');
            $table->string('judul_dokumen');
            $table->string('container')->nullable();
            $table->string('freight_location')->nullable();
            $table->string('nama_extra_service');
            $table->string('harga_extra_service');
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
        Schema::dropIfExists('relasi_dokumenspk_extra_service');
    }
}
