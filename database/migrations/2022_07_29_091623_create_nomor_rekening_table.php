<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomorRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomor_rekening', function (Blueprint $table) {
            $table->bigIncrements('id_rekening');
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening');
            $table->string('nomor_COA');
            $table->integer('total_rekening');
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
        Schema::dropIfExists('nomor_rekening');
    }
}
