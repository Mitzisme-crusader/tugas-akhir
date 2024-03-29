<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalUmumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_umum', function (Blueprint $table) {
            $table->bigIncrements('id_jurnal_umum');
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening');
            $table->string('nomor_COA');
            $table->string('keterangan_tagihan')->nullable();
            $table->integer('total_debit');
            $table->integer('total_kredit');
            $table->integer('hutang')->nullable();
            $table->integer('piutang')->nullable();
            $table->integer('jenis_tagihan')->nullable();
            $table->integer('status_aktif');
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
        Schema::dropIfExists('jurnal_umum');
    }
}
