<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class customer_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
            'nama_customer' => 'Rian Kusuma',
            'email_customer' => 'Rian_kusuma@gmail.com',
            'nama_perusahaan_customer' => 'PT Surya Jaya',
            'alamat_customer' => 'jalan ahmad yani',
            'provinsi_customer' => 'Surabaya, Jawa Timur',
            'npwp_customer' => '93.507',
            'alamat_pajak_customer' => 'ahmad yani',
            'kode_pos_customer' => '12345',
            'negara_customer' => 'Indonesia',
            'nomor_telepon_customer' => '12345',
            'status_aktif_customer' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('customer')->insert([
            'nama_customer' => 'Nikita Melia',
            'email_customer' => 'Nikita_mel@gmail.com',
            'nama_perusahaan_customer' => 'PT Nusa Raya',
            'alamat_customer' => 'jalan lakasantri',
            'provinsi_customer' => 'Surabaya, Jawa Timur',
            'npwp_customer' => '103.43',
            'alamat_pajak_customer' => 'Lakasantri',
            'kode_pos_customer' => '64298',
            'negara_customer' => 'Indonesia',
            'nomor_telepon_customer' => '12345',
            'status_aktif_customer' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
