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
            'judul_dokumen' => '001-SP-E-A-L-VII-2022',
            'id_service' => '1',
            'id_customer' => '1',
            'nama_customer' => 'customer pertama',
            'nama_perusahaan_customer' => 'PT Surya Jaya',
            'metode_pengiriman' => null,
            'nama_port' => 'tanjung priuk',
            'container' => '2',
            'negara_customer' => 'Indonesia',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('dokumen_spk')->insert([
            'judul_dokumen' => '002-SP-E-A-L-VII-2022',
            'id_service' => '2',
            'id_customer' => '1',
            'nama_customer' => 'customer pertama',
            'nama_perusahaan_customer' => 'PT Surya Jaya',
            'metode_pengiriman' => 'sea',
            'nama_port' => 'tanjung priuk',
            'origin' => 'jakarta',
            'destination' => 'Tokyo',
            'container' => null,
            'negara_customer' => 'Indonesia',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
