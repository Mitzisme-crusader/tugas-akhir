<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumen_simpan_berjalan_model extends Model
{
    protected $table = 'dokumen_simpan_berjalan';
    protected $primaryKey  = 'id_dokumen_simpan_berjalan';
    protected $fillable = [
        'nomor_SO',
        'nomor_aju',
        'consignee',
        'notify_party',
        'nama_customer',
        'verification_order',
        'commodity',
        'option_pengiriman',
        'POL',
        'POD',
        'option_container',
        'party_20',
        'party_40',
        'party_45',
        'berat_container',
        'nomor_container',
        'nomor_invoice',
        'vessal',
        'nomor_BL',
        'ETD',
        'ETA',
        'tanggal_terima_dokumen',
        'sending',
        'tanggal_nopen',
        'opsi_surat_penjaluran',
        'nomor_surat_penjaluran',
        'jumlah_PIB',
        'jumlah_notul',
        'tanggal_pemeriksaan_barang',
        'tanggal_DNP',
        'tanggal_SPPB',
        'SPPB',
        'tempat_penimbunan',
        'tanggal_pengiriman',
        'alamat_pembongkaran',
        'pemilik_trucking',
        'nopol_supir',
        'balik_depo',
        'tanggal_depo_kembali',
        'harga_trucking',
        'opsi_asal_asuransi',
        'nama_asuransi',
        'harga_asuransi',
    ];
}
