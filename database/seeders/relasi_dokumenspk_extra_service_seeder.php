<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class relasi_dokumenspk_extra_service_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relasi_dokumenspk_extra_service')->insert([
            'judul_dokumen' => '001-SP-E-A-L-VII-2022',
            'container' => 20,
            'freight_location' => '1',
            'nama_extra_service' => 'Trucking',
            'harga_extra_service' => '40000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relasi_dokumenspk_extra_service')->insert([
            'judul_dokumen' => '001-SP-E-A-L-VII-2022',
            'container' => 40,
            'freight_location' => '1',
            'nama_extra_service' => 'Trucking',
            'harga_extra_service' => '50000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relasi_dokumenspk_extra_service')->insert([
            'judul_dokumen' => '002-SP-E-A-L-VII-2022',
            'container' => null,
            'freight_location' => '1',
            'nama_extra_service' => 'Trucking',
            'harga_extra_service' => '10000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relasi_dokumenspk_extra_service')->insert([
            'judul_dokumen' => '002-SP-E-A-L-VII-2022',
            'container' => null,
            'freight_location' => '2',
            'nama_extra_service' => 'Shipping',
            'harga_extra_service' => '50000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
