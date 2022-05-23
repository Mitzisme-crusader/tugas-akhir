<?php
namespace App\Repository;

use App\Model\User;
use App\models\user_model;
use Illuminate\Support\Collection;

interface admin_repository_interface
{
   //Customer
   public function all(): Collection;
   public function add_customer($data_customer);
   public function delete_customer($id_customer);
   public function get_customer($target_kolom);
   public function find_customer($id);
   //Service
   public function add_service($data_service);
   public function get_service($target_kolom);
   public function all_service();
   //Dokumen SPK
   public function get_id_dokumen_terbaru();
   public function create_dokumen_spk($dokumen_spk);
   public function get_all_dokumen_SPK();
   public function search_dokumen_SPK($query, $attribute, $date_awal, $date_akhir);
   public function get_dokumen_SPK($judul_dokumen);
   public function create_relasi_dokumenspk_extra_service($data_relasi);
   public function get_relasi_dokumen_spk_extra_service($judul_dokumen);
   public function get_relasi_dokumen_spk_extra_service_freight_origin($judul_dokumen);
   public function get_relasi_dokumen_spk_extra_service_freight_destination($judul_dokumen);
   //Dokumen Simpan Berjalan
   public function create_dokumen_simpan_berjalan($dokumen_simpan_berjalan);
   public function update_dokumen_simpan_berjalan($dokumen_simpan_berjalan);
   public function find_dokumen_simpan_berjalan($id_dokumen);
   public function search_dokumen_simpan_berjalan($query,$attribute,$month);
   public function get_dokumen_simpan_berjalan_by_SO($nomor_so);
   public function get_all_dokumen_simpan_berjalan();
   //Dokumen SO
   public function get_id_dokumenSO_terbaru();
   public function add_dokumen_SO($data_dokumen_SO);
   public function add_relasi_dokumen_so_extra_service($data_relasi);
   public function get_relasi_dokumen_so_extra_service($nomor_so);
   public function delete_relasi_dokumen_so_extra_service($id_dokumen_SO);
   public function get_dokumen_so_by_nomor_so($nomor_so);
   public function get_all_dokumen_SO();
   public function find_dokumen_SO($id_dokumen_SO);
   //Tagihan
   //input tagihan vendor
   public function add_tagihan_vendor($data_tagihan_vendor);
   public function get_all_dokumen_SO_with_total_hutang();
   //input tagihan customer
   public function add_tagihan_customer($data_tagihan_customer);
   public function add_service_tagihan_customer($data_service_tagihan_customer);
   public function get_all_tagihan_customer();
   //port
   public function get_port($target_kolom);
   public function find_port($id);
}
