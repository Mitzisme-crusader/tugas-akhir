<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class service_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service')->insert([
            'nama_service' => 'Customer handling Export Import(PPJK)',
            'deskripsi_service' => 'Seperti yang kita ketahui bersama bahwa perdagangan international pasti memiliki banyak peraturan-peraturan yang mengatur semua produk yang melewati “Tata Niaga“ import & export di Wilayah Indonesia. Untuk memenuhi dan mempermudah keperluan client dalam hal ini, PT. Victory Transindo Laris Cemerlang juga siap membantu kepengurusan perizinan import dan export sesuai dengan UPDATE aturan Pemerintah yang berlaku.',
            'biaya_service' => '50000',
            'status_aktif_service' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('service')->insert([
            'nama_service' => 'International freight',
            'deskripsi_service' => 'Sebagai Perusahaan yang bergerak di bidang logistik, PT. Victory Transindo Laris Cemerlang memiliki jasa pelayanan pengiriman cargo baik via laut ataupun udara yang mana memiliki kelebihan dan kekurangan masing-masing. Jika para Importir atau Eksportir membutuhkan pengiriman cargo yang cepat, maka pengiriman via udara adalah pilihan yang tepat namun pengiriman via udara tidak bisa menampung cargo lebih banyak dibanding pengiriman via laut dan tarif freight via udara pun lebih mahal. Namun jika para Importir atau Eksportir membutuhkan pengiriman cargo dalam jumlah/space yang lebih, pengiriman via laut adalah pilihan yang tepat. Kami siap memberikan harga freight yang bersaing dari/ke seluruh dunia baik via udara maupun via laut, FCL maupun LCL, dan Port to Port ataupun Door to Door.',
            'biaya_service' => '50000',
            'status_aktif_service' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
