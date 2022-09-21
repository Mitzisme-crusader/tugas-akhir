<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class nomor_chart_of_account_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nomor_chart_of_account')->insert([
            'nomor_COA' => '1234',
            'nama_jenis_COA' => 'kas perusahaan',
            'total_COA' => '100000',
            'status_aktif' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('nomor_chart_of_account')->insert([
            'nomor_COA' => '12345',
            'nama_jenis_COA' => 'Bank BCA VTLC 1',
            'total_COA' => '200000',
            'status_aktif' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
