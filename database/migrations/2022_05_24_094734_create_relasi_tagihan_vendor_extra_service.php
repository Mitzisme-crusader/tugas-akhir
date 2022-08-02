<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelasiTagihanVendorExtraService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_tagihan_vendor_extra_service', function (Blueprint $table) {
            $table->bigIncrements('id_relasi_tagihan_vendor_extra_service');
            $table->unsignedBigInteger('id_tagihan_vendor');
            $table->foreign('id_tagihan_vendor')->references('id_tagihan_vendor')->on('tagihan_vendor');
            $table->string('nama_service');
            $table->integer('quantity_service')->nullable();
            $table->string('container_service')->nullable();
            $table->integer('harga_service')->nullable();
            $table->integer('diskon_service')->nullable();
            $table->integer('pajak_service')->nullable();
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
        Schema::dropIfExists('relasi_tagihan_vendor_extra_service');
    }
}
