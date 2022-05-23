<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class dokumenSpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokumen_spk')->insert([
            'nama_customer' => 'customer_pertama',
            'judul_dokumen' => '001-SP-E-A-L-V-2022',
            'id_service' => '1',
            'id_customer' => '1',
            'nama_customer' => 'customer pertama',
            'nama_perusahaan_customer' => 'PT Surya Jaya',
            'negara_customer' => 'Indonesia',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
