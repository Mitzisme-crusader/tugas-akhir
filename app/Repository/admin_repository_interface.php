<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface admin_repository_interface
{
   //Customer
   public function all();
   public function add_customer($data_customer);
   public function delete_customer($id_customer);
   public function get_customer($target_kolom);
   public function find_customer($id);
   //Service
   public function add_service($data_service);
   public function get_service($target_kolom);
   public function all_service();
    //port
    public function get_port($target_kolom);
    public function find_port($id);
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
}
