<?php

namespace Database\Seeders;

use App\Models\dokumen_so_model;
use App\Models\relasi_dokumenspk_extra_service_model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            user_seeder::class,
            customer_seeder::class,
            // vendor_seerder::class,
            service_seeder::class,
            port_seeder::class,
            dokumen_simpan_berjalan_seeder::class,
            dokumenSpkSeeder::class,
            relasi_dokumenspk_extra_service_seeder::class,
            relasi_dokumen_so_extra_service_seeder::class,
            dokumen_so_seeder::class,
            nomor_chart_of_account_seeder::class,
        ]);
    }
}
