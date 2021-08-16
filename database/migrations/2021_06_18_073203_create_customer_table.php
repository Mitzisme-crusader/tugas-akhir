<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id_customer');
            $table->string('nama_customer');
            $table->string('email_customer');
            $table->string('nama_perusahaan_customer');
            $table->string('alamat_customer');
            $table->string('provinsi_customer');
            $table->string('npwp_customer');
            $table->string('alamat_pajak_customer');
            $table->integer('kode_pos_customer');
            $table->string('negara_customer');
            $table->string('nomor_telepon_customer');
            $table->integer("status_aktif_customer");
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
        Schema::dropIfExists('customer');
    }
}
