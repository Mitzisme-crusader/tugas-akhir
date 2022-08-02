<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class relasi_dokumen_so_extra_service_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relasi_dokumen_so_extra_service')->insert([
            'nomor_so' => 'SO22071',
            'nama_service' => 'trucking',
            'judul_dokumen_spk' => '001-SP-E-A-L-VII-2022',
            'quantity_service' => '1',
            'container_service' => 20,
            'harga_service' => '40000',
            'diskon_service' => '0',
            'pajak_service' => '0',
            'freight_location' => '1',
            'total_service' => '40000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relasi_dokumen_so_extra_service')->insert([
            'nomor_so' => 'SO22071',
            'nama_service' => 'trucking',
            'judul_dokumen_spk' => '001-SP-E-A-L-VII-2022',
            'quantity_service' => '1',
            'container_service' => 20,
            'harga_service' => '50000',
            'diskon_service' => '0',
            'pajak_service' => '0',
            'freight_location' => '1',
            'total_service' => '50000',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
