<?php

namespace Database\Seeders;

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
        ]);
    }
}
