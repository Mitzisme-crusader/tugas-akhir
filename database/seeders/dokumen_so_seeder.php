<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class dokumen_so_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokumen_so')->insert([
            'nomor_so'=> 'SO22071',
            'tanggal_so' => '2022-07-29',
            'judul_dokumen_spk' => '001-SP-E-A-L-VII-2022',
            'nama_customer' => 'customer pertama',
            'alamat_customer' => 'jalan ahmad yani- Surabaya, Jawa Timur- Indonesia',
            'id_service' => '1',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('dokumen_so')->insert([
            'nomor_so'=> 'SO22072',
            'tanggal_so' => '2022-07-29',
            'judul_dokumen_spk' => '002-SP-E-A-L-VII-2022',
            'nama_customer' => 'customer pertama',
            'alamat_customer' => 'jalan ahmad yani- Surabaya, Jawa Timur- Indonesia',
            'id_service' => '2',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('dokumen_so')->insert([
            'nomor_so'=> 'SO22073',
            'tanggal_so' => '2022-07-29',
            'judul_dokumen_spk' => '002-SP-E-A-L-VII-2022',
            'nama_customer' => 'customer pertama',
            'alamat_customer' => 'jalan ahmad yani- Surabaya, Jawa Timur- Indonesia',
            'id_service' => '2',
            'status_aktif_dokumen' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
