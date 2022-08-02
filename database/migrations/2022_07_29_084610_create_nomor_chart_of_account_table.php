<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomorChartOfAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomor_chart_of_account', function (Blueprint $table) {
            $table->bigIncrements('id_COA');
            $table->string('nomor_COA');
            $table->string('nama_jenis_COA');
            $table->integer('total_COA');
            $table->integer("status_aktif_COA");
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
        Schema::dropIfExists('nomor_chart_of_account');
    }
}
