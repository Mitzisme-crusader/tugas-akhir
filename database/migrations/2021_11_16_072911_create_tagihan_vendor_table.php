<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_vendor', function (Blueprint $table) {
            $table->bigIncrements('id_tagihan_vendor');
            $table->string('nomor_so');
            $table->string('bank_pelunasan')->nullable();
            $table->string('vendor_service');
            $table->string('nama_service');
            $table->integer('quantity_service')->nullable();
            $table->string('container_service')->nullable();
            $table->integer('harga_service')->nullable();
            $table->integer('diskon_service')->nullable();
            $table->integer('pajak_service')->nullable();
            $table->longText('keterangan_tagihan')->nullable();
            $table->integer('hutang');
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
        Schema::dropIfExists('tagihan_vendor');
    }
}
