<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface dokumen_SO_repository_interface
{
   //Dokumen SO
   public function get_id_dokumenSO_terbaru();
   public function create($data_dokumen_SO);
   public function add_relasi_dokumen_so_extra_service($data_relasi);
   public function get_relasi_dokumen_so_extra_service($nomor_so,$freight_location);
   public function delete_relasi_dokumen_so_extra_service($id_dokumen_SO);
   public function get_dokumen_so_by_nomor_so($nomor_so);
   public function all() :Collection;
   public function find_dokumen_SO($id_dokumen_SO);
   public function add_tagihan_customer($data_tagihan_customer);
   public function add_service_tagihan_customer($data_service_tagihan_customer);
}
