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
            $table->string('nama_rekening');
            $table->string('nomor_rekening');
            $table->unsignedBigInteger('id_COA');
            $table->foreign('id_COA')->references('id_COA')->on('nomor_chart_of_account');
            $table->integer('total_rekening');
            $table->integer('status_aktif_rekening');
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
