<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class nomor_rekening_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nomor_rekening')->insert([
            'nama_rekening' => 'Kas Perusahaan 1',
            'nomor_rekening' => '12031414',
            'nomor_COA' => '1234',
            'total_rekening' => '100000',
            'status_aktif' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('nomor_rekening')->insert([
            'nama_rekening' => 'Bank VTCL 3 ',
            'nomor_rekening' => '1203142151531',
            'nomor_COA' => '12345',
            'total_rekening' => '100000',
            'status_aktif' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
