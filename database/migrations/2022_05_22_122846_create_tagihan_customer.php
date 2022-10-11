<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_customer', function (Blueprint $table) {
            $table->bigIncrements('id_tagihan_customer');
            $table->string('nomor_so');
            $table->string('bank_pelunasan')->nullable();
            $table->integer('piutang');
            $table->string('keterangan_tagihan')->nullable();
            $table->integer('total_service');
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
        Schema::dropIfExists('tagihan_customer');
    }
}
