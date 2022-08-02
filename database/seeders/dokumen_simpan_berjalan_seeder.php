<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class dokumen_simpan_berjalan_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokumen_simpan_berjalan')->insert([
            'nomor_SO' => "SO2112",
            'nomor_aju' => "1144",
            'consignee' => "PT.ASTA",
            'notify_party' => "PT.ASTA",
            'nama_customer' => "PT.ASTA",
            'verification_order' => "IPT111",
            'commodity' => "speaker",
            'option_pengiriman' => "luar_negeri",
            'POL' => "Shanghai",
            'POD' => "Surabaya",
            'option_container' => "FCL",
            'party_20' => "1",
            'party_40' => null,
            'party_45' => null,
            'berat_container' => null,
            'nomor_container' => "112",
            'nomor_invoice' => 112,
            'vessal' => "Sea Cruise",
            'nomor_BL' => 1212,
            'ETD' => null,
            'ETA' => '2022-5-10',
            'tanggal_terima_dokumen' => null,
            'sending' => null,
            'tanggal_nopen' => null,
            'opsi_surat_penjaluran' => "SPJM",
            'nomor_surat_penjaluran' => "123",
            'jumlah_PIB' => "100000",
            'jumlah_notul' => "1000000",
            'tanggal_pemeriksaan_barang' => null,
            'tanggal_DNP' => null,
            'tanggal_SPPB' => null,
            'tempat_penimbunan' => "CTTL",
            'tanggal_pengiriman' => null,
            'alamat_pembongkaran' => "Surabaya",
            'pemilik_trucking' => "ACL",
            'nopol_supir' => "123",
            'balik_depo' => null,
            'tanggal_depo_kembali' => null,
            'harga_trucking' => "750000",
            'opsi_asal_asuransi' => "luar_negeri",
            'nama_asuransi' => "Asta",
            'harga_asuransi' => "10000",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('dokumen_simpan_berjalan')->insert([
            'nomor_SO' => "SO22071",
            'nomor_aju' => "1144",
            'consignee' => "PT.ASTA",
            'notify_party' => "PT.ASTA",
            'nama_customer' => "Michael",
            'verification_order' => "IPT123",
            'commodity' => "SOAP",
            'option_pengiriman' => "export",
            'POL' => "Shanghai",
            'POD' => "Surabaya",
            'option_container' => "FCL",
            'party_20' => "1",
            'party_40' => null,
            'party_45' => null,
            'berat_container' => null,
            'nomor_container' => "SGH11",
            'nomor_invoice' => 112,
            'vessal' => "Sea Cruise",
            'nomor_BL' => 1212,
            'ETD' => '2022-07-29',
            'ETA' => '2022-07-30',
            'tanggal_terima_dokumen' => '2022-07-31',
            'sending' => '2022-08-01',
            'tanggal_nopen' => '2022-08-02',
            'opsi_surat_penjaluran' => "SPJM",
            'nomor_surat_penjaluran' => "123",
            'jumlah_PIB' => "100000",
            'jumlah_notul' => "10000",
            'tanggal_pemeriksaan_barang' => null,
            'tanggal_DNP' => null,
            'tanggal_SPPB' => '2022-08-03',
            'SPPB' => '184351',
            'tempat_penimbunan' => "CTTL",
            'tanggal_pengiriman' => null,
            'alamat_pembongkaran' => "Surabaya",
            'pemilik_trucking' => "ACL",
            'nopol_supir' => "123",
            'balik_depo' => null,
            'tanggal_depo_kembali' => null,
            'harga_trucking' => null,
            'opsi_asal_asuransi' => "luar_negeri",
            'nama_asuransi' => "Asta",
            'harga_asuransi' => "10000",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
