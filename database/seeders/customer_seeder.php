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
            'nama' => 'customer_pertama',
            'email' => 'customer_pertama@gmail.com',
            'npwp' => '93.507',
            'alamat_pajak' => 'ahmad yani',
            'kode_pos' => '12345',
            'negara' => 'Indonesia',
            'nomor_telepon' => '12345',
            'status_aktif' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
