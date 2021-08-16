<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class service_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service')->insert([
            'nama_service' => 'Customer handling Export Import(PPJK)',
            'deskripsi_service' => 'Seperti yang kita ketahui bersama bahwa perdagangan international pasti memiliki banyak peraturan-peraturan yang mengatur semua produk yang melewati “Tata Niaga“ import & export di Wilayah Indonesia. Untuk memenuhi dan mempermudah keperluan client dalam hal ini, PT. Victory Transindo Laris Cemerlang juga siap membantu kepengurusan perizinan import dan export sesuai dengan UPDATE aturan Pemerintah yang berlaku.',
            'biaya_service' => '50000',
            'status_aktif_service' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
